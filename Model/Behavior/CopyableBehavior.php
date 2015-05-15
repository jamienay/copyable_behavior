<?php
/**
 * Copyable Behavior class file.
 *
 * Adds ability to copy a model record, including all hasMany and hasAndBelongsToMany
 * associations. Relies on Containable behavior, which this behavior will attach
 * on the fly as needed.
 *
 * HABTM relationships are just duplicated in the join table, while hasMany and hasOne
 * records are recursively copied as well.
 *
 * Usage is straightforward:
 *   $id = the id of the record to be copied (int or uuid)
 *
 * From model:
 *   $this->copy($id);
 * From controller:
 *   $this->MyModel->copy($id);
 *
 * Primary Public Method:
 *   copy($id, $settings)   --> $saved
 *
 * Secondary Public Methods:
 *   copyGenerateContain()  --> $contain (from settings, or generated)
 *   copyFindData($id)      --> $data    (find first w/ contains)
 *   copyPrepareData($data) --> $data    (convert data w/o foreignKey/stripFields)
 *   copySaveAll($data)     --> $saved   (do saveAll and update masterKey)
 *
 * @filesource
 * @author			Jamie Nay
 * @copyright       Jamie Nay
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link            http://github.com/jamienay/copyable_behavior
 */
class CopyableBehavior extends ModelBehavior {

/**
 * Behavior settings
 */
	public $settings = array();

/**
 * Default values for settings.
 *
 * - recursive: whether to copy hasMany and hasOne records
 * - habtm: whether to copy hasAndBelongsToMany associations
 * - stripFields: fields to strip during copy process
 * - ignore: aliases of any associations that should be ignored, using dot (.) notation.
 * - contain: contain part of options for find first (optional, if empty, generates)
 * - saveAllOptions: options for saveAll()
 * - masterKey: if set to a field, will update all records with the new id
 */
	protected $_defaults = array(
		'recursive' => true,
		'habtm' => true,
		'stripFields' => array(
			'id',
			'created',
			'modified',
			'lft',
			'rght'
		),
		'ignore' => array(),
		'contain' => array(),
		'saveAllOptions' => array(
			'validate' => false,
			'deep' => true
		),
		'masterKey' => null
	);

/**
 * Configuration method.
 *
 * @param object $Model Model object
 * @param array $settings Config array
 * @return boolean
 */
	public function setup(Model $Model, $settings = array()) {
		$this->settings[$Model->alias] = array_merge($this->_defaults, $settings);
		return true;
	}

/**
 * Get settings and merge in any custom "run time" overrides
 *
 * @param object $Model Model object
 * @param array $settings Config array
 * @return array $settings
 */
	public function settings(Model $Model, $settings = array()) {
		return array_merge(
			$this->_defaults,
			// when we start copy, we set these "sticky" settings for this run
			(!empty($this->settings['copyRunning']) ? $this->settings['copyRunning'] : array()),
			// Model specific settings, overwrite "sticky" settings
			(!empty($this->settings[$Model->alias]) ? $this->settings[$Model->alias] : array()),
			// anything passed into this function always wins/overwrites
			$settings
		);
	}

/**
 * Copy method.
 *
 * @param object $Model model object
 * @param mixed $id String or integer model ID
 * @param array $settings optionally pass in custom settings
 * @return boolean
 */
	public function copy(Model $Model, $id, $settings = array()) {
		// clear the "sticky" settings for copyRunning
		$this->settings['copyRunning'] = array();
		// get the clean list of settings for the parent Model + runtime settings
		$settings = $this->settings($Model, $settings);
		// set the "sticky" settings for copyRunning
		$this->settings['copyRunning'] = $settings;

		// get data
		$record = $Model->copyFindData($id, $settings);
		// stash a copy of this record before prepare
		$Model->copyData['beforePrepare'] = $record;

		// prepare / convert data
		$record = $this->copyPrepareData($Model, $record);

		// prepare / inject data
		$record = $this->_copyInjectData($Model, $record, $settings);

		// stash a copy of this record after prepare
		$Model->copyData['afterPrepare'] = $record;

		if (empty($record)) {
			$this->log("Copy of $id resulted in empty data, after convertion");
			return false;
		}

		// save data
		return $this->copySaveAll($Model, $record);
	}

/**
 * Find first on the Model with the contain for copy
 * Used by copy()
 * Used by _updateMasterKey()
 *
 * @param object $Model model object
 * @param mixed $id String or integer model ID
 * @param array $settings optionally pass in custom settings
 * @return boolean
 */
	public function copyFindData(Model $Model, $id, $settings = array()) {
		$settings = $this->settings($Model, $settings);

		// clear stash of data on the Model (useful for debugging)
		$Model->copyData = [];
		$record = $Model->find('first', array(
			'conditions' => array(
				$Model->escapeField() => $id
			),
			'contain' => $this->copyGenerateContain($Model),
		));

		if (empty($record)) {
			$this->log("Copy of $id resulted in empty data, after find");
			return false;
		}

		return $record;
	}

/**
 * Wrapper method that combines the results of _generateContainHasRecursivly()
 * with the models' HABTM associations.
 *
 * @param object $Model Model object
 * @return array $contain
 */
	public function copyGenerateContain(Model $Model) {
		if (!$this->_verifyContainable($Model)) {
			return false;
		}

		// support for custom configured contain for this Model
		$settings = $this->settings($Model);
		if (!empty($settings['contain'])) {
			return $settings['contain'];
		}

		// dynamically create a contains
		$contain = array();
		//   ignore belongsTo (no need, since field is on this Model)
		//   recursive get hasOne and hasMany
		$contain = $this->_generateContainHasRecursivly($Model, $contain);
		//   get all HABTM, but not recursively
		$contain = $this->_generateContainHABTM($Model, $contain);

		$contain = $this->_generateContainRemoveIgnored($Model, $contain);
		return $contain;
	}

/**
 * Backwards compatible alias
 *
 * @param object $Model Model object
 * @return array
 */
	public function generateContain(Model $Model) {
		return $this->copyGenerateContain($Model);
	}

/**
 * Removes any ignored associations, as defined in the model settings,
 * from the $contain array.
 *
 * @param object $Model Model object
 * @param array $contain
 * @return array $contain
 */
	protected function _generateContainRemoveIgnored(Model $Model, $contain) {
		$settings = $this->settings($Model);

		if (!$settings['ignore']) {
			return $contain;
		}
		$ignore = array_unique($settings['ignore']);
		foreach ($ignore as $path) {
			if (Hash::check($contain, $path)) {
				$contain = Hash::remove($contain, $path);
			}
		}
		return $contain;
	}

/**
 * Strips all records for belongsTo associations
 *
 * @param object $Model model object
 * @param array $record
 * @return array $record
 */
	protected function _convertChildrenBelongsTo(Model $Model, $record) {
		return array_diff_key($record, $Model->belongsTo);
	}

/**
 * Strips primary keys and other unwanted fields
 * from hasOne
 *
 * @param object $Model model object
 * @param array $record
 * @return array $record
 */
	protected function _convertChildrenHasOne(Model $Model, $record) {
		foreach ($Model->hasOne as $alias => $config) {
			if (!isset($record[$alias])) {
				continue;
			}

			if (empty($record[$alias])) {
				unset($record[$alias]);
				continue;
			}

			$record[$alias] = $this->_convertChild($Model, $record[$alias], $alias, $config);
			if (empty($record[$alias])) {
				unset($record[$alias]);
			}
		}
		return $record;
	}

/**
 * Strips primary keys and other unwanted fields
 * from hasMany
 *
 * @param object $Model model object
 * @param array $record
 * @return array $record
 */
	protected function _convertChildrenHasMany(Model $Model, $record) {
		foreach ($Model->hasMany as $alias => $config) {
			if (!isset($record[$alias])) {
				continue;
			}

			if (empty($record[$alias])) {
				unset($record[$alias]);
				continue;
			}

			foreach (array_keys($record[$alias]) as $i) {
				$record[$alias][$i] = $this->_convertChild($Model, $record[$alias][$i], $alias, $config);
				if (empty($record[$alias][$i])) {
					unset($record[$alias][$i]);
				}
			}
			if (empty($record[$alias])) {
				unset($record[$alias]);
			}
		}
		return $record;
	}

/**
 * Strips primary keys and other unwanted fields
 * from a single hasOne and hasMany records.
 *
 * @param object $Model model object
 * @param array $data
 * @param string $alias of the child Model
 * @param array $config of the Association
 * @return array $data
 */
	protected function _convertChild(Model $Model, $data, $alias, $config) {
		$data = $this->_stripFields($Model, $data);

		if (isset($data[$config['foreignKey']])) {
			unset($data[$config['foreignKey']]);
		}

		$data = $this->copyPrepareData($Model->{$alias}, $data);

		// is this completely empty (contains only empty values)?
		//   if so, strip...
		$filtered = Hash::filter($data);
		if (empty($filtered)) {
			return [];
		}

		return $data;
	}

/**
 * Strips primary and parent foreign keys (where applicable)
 * from $record in preparation for saving.
 *
 * @param object $Model Model object
 * @param array $record
 * @return array $record
 */
	public function copyPrepareData(Model $Model, $record) {
		// validation
		if (empty($record) || !is_array($record)) {
			return array();
		}

		// support for custom copyPrepareData on the Model
		//   NOTE: beware of recursion, depending on how you implement
		if (method_exists($Model, 'copyPrepareData')) {
			$record = $Model->copyPrepareData($record);
		}
		if (method_exists($Model, 'copyPrepareDataCustom')) {
			$record = $Model->copyPrepareDataCustom($record);
		}

		// clean this set of data
		$record = $this->_stripFields($Model, $record);
		if (!empty($record[$Model->alias])) {
			$record[$Model->alias] = $this->_stripFields($Model, $record[$Model->alias]);
		}

		// recurse into associations, based on type
		$record = $this->_convertHabtm($Model, $record);
		$record = $this->_convertChildrenBelongsTo($Model, $record);
		$record = $this->_convertChildrenHasOne($Model, $record);
		$record = $this->_convertChildrenHasMany($Model, $record);

		return $record;
	}

/**
 * Injects data into prepare data, optional
 *
 * must be setup in $settings but can be passed into the copy() method
 *
 * @param object $Model Model object
 * @param array $record
 * @param array $settings
 * @return array $record
 */
	protected function _copyInjectData(Model $Model, $record, $settings) {
		if (empty($settings['inject']) || !is_array($settings['inject'])) {
			return $record;
		}

		return Hash::merge($record, $settings['inject']);
	}

/**
 * Loops through any HABTM results in $record and plucks out
 * the join table info, stripping out the join table primary
 * key and the primary key of $Model. This is done instead of
 * a simple collection of IDs of the associated records, since
 * HABTM join tables may contain extra information (sorting
 * order, etc).
 *
 * @param Model $Model Model object
 * @param array $record
 * @return array modified $record
 */
	protected function _convertHabtm(Model $Model, $record) {
		$settings = $this->settings($Model);
		if (empty($settings['habtm'])) {
			return $record;
		}
		foreach ($Model->hasAndBelongsToMany as $alias => $config) {
			$className = pluginSplit($config['className']);
			$className = $className[1];
			if (!isset($record[$className])) {
				continue;
			}
			if (empty($record[$className])) {
				unset($record[$className]);
				continue;
			}

			// we might have HABTM values via a WITH alias
			//   [Tag => [
			//     [ArticlesTag => [...],
			//     [ArticlesTag => [...],
			//   ]]
			$records = $this->_convertHabtmUsingWith($Model, $record[$className], $config);
			if (!empty($records)) {
				$record[$className] = $records;
				continue;
			}

			// we might have HABTM values via a simple nested list
			//   [Tag => [
			//     [...],
			//     [...],
			//   ]]
			$records = $this->_convertHabtmUsingAsIds($Model, $record[$className], $config);
			if (!empty($records)) {
				$record[$className] = $records;
				continue;
			}

			unset($record[$className]);

		}

		return $record;
	}
	protected function _convertHabtmUsingWith(Model $Model, $records, $config) {
		$records = Hash::extract($records, '{n}.' . $config['with']);

		foreach ($records as $joinKey => $joinVal) {
			$records[$joinKey] = $this->_stripFields($Model, $joinVal);

			if (array_key_exists($config['foreignKey'], $joinVal)) {
				unset($records[$joinKey][$config['foreignKey']]);
			}
		}

		return $records;
	}
	protected function _convertHabtmUsingAsIds(Model $Model, $records, $config) {
		$ids = [];
		foreach ($records as $joinKey => $joinVal) {
			if (empty($joinVal['id'])) {
				continue;
			}
			$ids[] = $joinVal['id'];
		}

		if (empty($ids)) {
			return [];
		}

		return [$config['className'] => $ids];
	}

/**
 * Performs the actual creation and save.
 *
 * This should only be done AFTER we have perpared/converted the record.
 *
 * @param object $Model Model object
 * @param array $record full data record to save (converted)
 * @return mixed
 */
	public function copySaveAll(Model $Model, $record) {
		$settings = $this->settings($Model);
		$Model->create();
		$saved = $Model->saveAll($record, $settings['saveAllOptions']);
		$id = $Model->id;

		if ($settings['masterKey']) {
			$record = $this->_updateMasterKey($Model, $id);
			$Model->saveAll($record, $settings['saveAllOptions']);
		}
		return $saved;
	}

/**
 * Runs through to update the master key for deep copying.
 *
 * @param Model $Model
 * @return array
 */
	protected function _updateMasterKey(Model $Model, $id) {
		$record = $Model->copyFindData($id, array());
		$record = $this->_masterKeyLoop($Model, $record, $Model->id);
		return $record;
	}

/**
 * Called by _updateMasterKey as part of the copying process for deep recursion.
 *
 * @param Model $Model
 * @param array $record
 * @param integer $id
 * @return array
 */
	protected function _masterKeyLoop(Model $Model, $record, $id) {
		$settings = $this->settings($Model);
		foreach ($record as $key => $val) {
			if (is_array($val)) {
				if (empty($val)) {
					unset($record[$key]);
				}
				foreach ($val as $innerKey => $innerVal) {
					if (is_array($innerVal)) {
						$record[$key][$innerKey] = $this->_masterKeyLoop($Model, $innerVal, $id);
					}
				}
			}

			if (!isset($val[$settings['masterKey']])) {
				continue;
			}

			$record[$settings['masterKey']] = $id;
		}
		return $record;
	}

/**
 * Generates a contain array for Containable behavior by recursively looping through
 * - $Model->hasMany associations
 * - $Model->hasOne associations
 *
 * @param object $Model Model object
 * @param array $contain
 * @return array $contain
 */
	protected function _generateContainHasRecursivly(Model $Model, $contain = array()) {
		$settings = $this->settings($Model);
		if (!isset($settings) || !$settings['recursive']) {
			return $contain;
		}

		$children = array_merge(array_keys($Model->hasMany), array_keys($Model->hasOne));
		foreach ($children as $child) {
			if ($Model->alias == $child) {
				// do not contain self
				continue;
			}
			// recursive contain these children's children
			//   [Comment => [User => [Profile => []]]]
			$contain[$child] = $this->_generateContainHasRecursivly($Model->{$child});
		}

		return $contain;
	}

/**
 * Generates a contain array for Containable behavior by looking for only
 * - $Model->hasAndBelongsToMany associations
 *
 * @param object $Model Model object
 * @param array $contain
 * @return array $contain
 */
	protected function _generateContainHABTM(Model $Model, $contain = array()) {
		$settings = $this->settings($Model);
		if (!isset($settings) || !$settings['habtm']) {
			return $contain;
		}

		foreach (array_keys($Model->hasAndBelongsToMany) as $habtm) {
			$contain[$habtm] = array();
		}

		return $contain;
	}

/**
 * Strips unwanted fields from $record, taken from
 * the 'stripFields' setting.
 *
 * @param object $Model Model object
 * @param array $record
 * @return array
 */
	protected function _stripFields(Model $Model, $record) {
		$settings = $this->settings($Model);
		foreach ($settings['stripFields'] as $field) {
			if (array_key_exists($field, $record)) {
				unset($record[$field]);
			}
		}

		return $record;
	}

/**
 * Attaches Containable if it's not already attached.
 *
 * @param object $Model Model object
 * @return boolean
 */
	protected function _verifyContainable(Model $Model) {
		if (!$Model->Behaviors->attached('Containable')) {
			return $Model->Behaviors->attach('Containable');
		}

		return true;
	}

}
