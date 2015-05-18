<?php
/* Copyable Test cases generated on: 2013-09-26 10:09:29 : 1380204749*/
App::uses('CopyableBehavior', 'Copyable.Model/Behavior');
App::uses('Model', 'Model');
App::uses('AppModel', 'Model');


/**
 * Article class
 *
 * @package       Cake.Test.Case.Model
 * /
class Article extends CakeTestModel {
	public $name = 'Article';
	public $belongsTo = array('User');
	public $hasMany = array('Comment' => array('dependent' => true));
	public $hasAndBelongsToMany = array('Tag');
	public $actsAs = array(
		'Copyable.Copyable' => array()
	);
}
/* -- */

require(CAKE . 'Test' . DS . 'Case' . DS . 'Model' . DS . 'models.php');


class CopyableBehaviorTest extends CakeTestCase {


/**
 * Whether backup global state for each test method or not
 *
 * @var bool
 */
	public $backupGlobals = false;
/**
 * settings property
 *
 * @var array
 */
	public $settings = array(
		'containArticle' => array(
			// belongsTo
			'User',
			// hasOne
			'Featured',
			// hasOne -> belongsTo
			'Featured.ArticleFeatured',
			// hasMany
			'Comment',
			// hasMany -> belongsTo
			'Comment.User',
			// hasAndBelongsToMany
			'Tag',
		),
	);

/**
 * settings property
 *
 * @var array
 */
		public $expectedFromFixtures = array(
			0 => array(
				'Article' => array(
					'id' => '1',
					'user_id' => '1',
					'title' => 'First Article',
					'body' => 'First Article Body',
					'published' => 'Y',
					'created' => '2007-03-18 10:39:23',
					'updated' => '2007-03-18 10:41:31',
				),
				'User' => array(
					'id' => '1',
					'user' => 'mariano',
					'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
					'created' => '2007-03-17 01:16:23',
					'updated' => '2007-03-17 01:18:31',
				),
				'Featured' => array(
					'id' => '1',
					'article_featured_id' => '1',
					'category_id' => '1',
					'published_date' => '2007-03-31 10:39:23',
					'end_date' => '2007-05-15 10:39:23',
					'created' => '2007-03-18 10:39:23',
					'updated' => '2007-03-18 10:41:31',
					'ArticleFeatured' => array(
						'id' => '1',
						'user_id' => '1',
						'title' => 'First Article',
						'body' => 'First Article Body',
						'published' => 'Y',
						'created' => '2007-03-18 10:39:23',
						'updated' => '2007-03-18 10:41:31',
					),
				),
				'Comment' => array(
					0 => array(
						'id' => '1',
						'article_id' => '1',
						'user_id' => '2',
						'comment' => 'First Comment for First Article',
						'published' => 'Y',
						'created' => '2007-03-18 10:45:23',
						'updated' => '2007-03-18 10:47:31',
						'User' => array(
							'id' => '2',
							'user' => 'nate',
							'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
							'created' => '2007-03-17 01:18:23',
							'updated' => '2007-03-17 01:20:31',
						),
					),
					1 => array(
						'id' => '2',
						'article_id' => '1',
						'user_id' => '4',
						'comment' => 'Second Comment for First Article',
						'published' => 'Y',
						'created' => '2007-03-18 10:47:23',
						'updated' => '2007-03-18 10:49:31',
						'User' => array(
							'id' => '4',
							'user' => 'garrett',
							'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
							'created' => '2007-03-17 01:22:23',
							'updated' => '2007-03-17 01:24:31',
						),
					),
					2 => array(
						'id' => '3',
						'article_id' => '1',
						'user_id' => '1',
						'comment' => 'Third Comment for First Article',
						'published' => 'Y',
						'created' => '2007-03-18 10:49:23',
						'updated' => '2007-03-18 10:51:31',
						'User' => array(
							'id' => '1',
							'user' => 'mariano',
							'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
							'created' => '2007-03-17 01:16:23',
							'updated' => '2007-03-17 01:18:31',
						),
					),
					3 => array(
						'id' => '4',
						'article_id' => '1',
						'user_id' => '1',
						'comment' => 'Fourth Comment for First Article',
						'published' => 'N',
						'created' => '2007-03-18 10:51:23',
						'updated' => '2007-03-18 10:53:31',
						'User' => array(
							'id' => '1',
							'user' => 'mariano',
							'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
							'created' => '2007-03-17 01:16:23',
							'updated' => '2007-03-17 01:18:31',
						),
					),
				),
				'Tag' => array(
					0 => array(
						'id' => '1',
						'tag' => 'tag1',
						'created' => '2007-03-18 12:22:23',
						'updated' => '2007-03-18 12:24:31',
					),
					1 => array(
						'id' => '2',
						'tag' => 'tag2',
						'created' => '2007-03-18 12:24:23',
						'updated' => '2007-03-18 12:26:31',
					),
				),
			),
			1 => array(
				'Article' => array(
					'id' => '2',
					'user_id' => '3',
					'title' => 'Second Article',
					'body' => 'Second Article Body',
					'published' => 'Y',
					'created' => '2007-03-18 10:41:23',
					'updated' => '2007-03-18 10:43:31',
				),
				'User' => array(
					'id' => '3',
					'user' => 'larry',
					'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
					'created' => '2007-03-17 01:20:23',
					'updated' => '2007-03-17 01:22:31',
				),
				'Featured' => array(
					'id' => '2',
					'article_featured_id' => '2',
					'category_id' => '1',
					'published_date' => '2007-03-31 10:39:23',
					'end_date' => '2007-05-15 10:39:23',
					'created' => '2007-03-18 10:39:23',
					'updated' => '2007-03-18 10:41:31',
					'ArticleFeatured' => array(
						'id' => '2',
						'user_id' => '3',
						'title' => 'Second Article',
						'body' => 'Second Article Body',
						'published' => 'Y',
						'created' => '2007-03-18 10:41:23',
						'updated' => '2007-03-18 10:43:31',
					),
				),
				'Comment' => array(
					0 => array(
						'id' => '5',
						'article_id' => '2',
						'user_id' => '1',
						'comment' => 'First Comment for Second Article',
						'published' => 'Y',
						'created' => '2007-03-18 10:53:23',
						'updated' => '2007-03-18 10:55:31',
						'User' => array(
							'id' => '1',
							'user' => 'mariano',
							'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
							'created' => '2007-03-17 01:16:23',
							'updated' => '2007-03-17 01:18:31',
						),
					),
					1 => array(
						'id' => '6',
						'article_id' => '2',
						'user_id' => '2',
						'comment' => 'Second Comment for Second Article',
						'published' => 'Y',
						'created' => '2007-03-18 10:55:23',
						'updated' => '2007-03-18 10:57:31',
						'User' => array(
							'id' => '2',
							'user' => 'nate',
							'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
							'created' => '2007-03-17 01:18:23',
							'updated' => '2007-03-17 01:20:31',
						),
					),
				),
				'Tag' => array(
					0 => array(
						'id' => '1',
						'tag' => 'tag1',
						'created' => '2007-03-18 12:22:23',
						'updated' => '2007-03-18 12:24:31',
					),
					1 => array(
						'id' => '3',
						'tag' => 'tag3',
						'created' => '2007-03-18 12:26:23',
						'updated' => '2007-03-18 12:28:31',
					),
				),
			), 2=> array(
				'Article' => array(
					'id' => '3',
					'user_id' => '1',
					'title' => 'Third Article',
					'body' => 'Third Article Body',
					'published' => 'Y',
					'created' => '2007-03-18 10:43:23',
					'updated' => '2007-03-18 10:45:31',
				),
				'User' => array(
					'id' => '1',
					'user' => 'mariano',
					'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
					'created' => '2007-03-17 01:16:23',
					'updated' => '2007-03-17 01:18:31',
				),
				'Featured' => array(
					'id' => NULL,
					'article_featured_id' => NULL,
					'category_id' => NULL,
					'published_date' => NULL,
					'end_date' => NULL,
					'created' => NULL,
					'updated' => NULL,
				),
				'Comment' => array(
				),
				'Tag' => array(
				),
			),
		);


/**
 * fixtures property
 *
 * @var array
 */
	public $fixtures = array(
		'core.article',
		'core.user',
		'core.comment',
		'core.tag',
		'core.articles_tag',
		'core.featured',
		'core.article_featured',
		'core.article_featureds_tags',
		'core.category',
		'core.attachment',
		'plugin.copyable.widget',
		'plugin.copyable.articles_widget',
	);

/**
 * Start Test callback
 *
 * @param string $method
 * @return void
 * @access public
 */
	public function startTest($method) {
		parent::startTest($method);
		$this->Article = new Article();
		$this->Article->recursive = -1;
		$this->Article->Behaviors->load('Containable', array());
		$this->Article->Behaviors->load('Copyable.Copyable', array(
			'habtm' => true,
			'recursive' => true,
			'contain' => $this->settings['containArticle'],
		));

		// Article isn't bound to anything via hasOne()
		//   so this is a hack to bind it to
		//     hasOne Featured via article_featured_id
		$this->Article->Featured = ClassRegistry::init('Featured');
		$this->Article->bindModel(
			array(
				'hasOne' => array(
					'Featured' => array(
						'className' => 'Featured',
						'foreignKey' => 'article_featured_id',
					)
				)
			),
			false
		);

		/*
		$this->ArticleFeatured = new Article();
		$this->ArticleFeatured->recursive = -1;
		$this->ArticleFeatured->Behaviors->load('Containable');
		$this->ArticleFeatured->Behaviors->load('Copyable.Copyable', array());
		*/
	}

/**
 * End Test callback
 *
 * @param string $method
 * @return void
 * @access public
 */
	public function endTest($method) {
		parent::endTest($method);
		unset($this->Article);
		ClassRegistry::flush();
	}

/**
 * test this Test's Setup/data
 *
 * @return void
 */
	public function testSetupArticleFeatured() {
		$result = $this->Article->find('all', array(
			'contain' => $this->settings['containArticle'],
		));
		//echo var_export($result);
		$expected = $this->expectedFromFixtures;
		$this->assertEquals($expected, $result);
	}

/**
 * test settings
 *
 * @return void
 */
	public function testSettings() {
		// todo - will have to make a mock class to get access to settings
	}

/**
 * test settings
 *
 * @return void
 */
	public function testCopyGenerateContain() {

		// default settings - (when loaded/setup) - use them
		// set onto the Behavior as if configured on setup
		$settings = $this->Article->Behaviors->Copyable->settings['Article'];
		$this->assertEquals(
			$this->Article->copyGenerateContain(),
			$settings['contain']
		);

		// custom settings - use them
		$settings = array(
			'contain' => array(
				'Featured' => array(),
				'Featured.ArticleFeatured' => array(),
				'Comment' => array(),
				'Tag' => array(),
				'Tag.User' => array(),
				'Foobar' => array(),
			)
		);
		// set onto the Behavior as if configured on setup
		$this->Article->Behaviors->Copyable->settings['Article'] = $settings;
		$this->assertEquals(
			$this->Article->copyGenerateContain(),
			$settings['contain']
		);

		// remove contain from settings on the Behavior as if never configured
		$this->Article->Behaviors->Copyable->settings['Article'] = array(
			'recursive' => true,
			'habtm' => true,
		);

		// no settings -- generate it
		$this->assertEquals(
			$this->Article->copyGenerateContain(),
			array(
				// ignores belongsTo
				// finds hasOne
				'Featured' => array(),
				// finds hasMany
				'Comment' => array(
					// recurses into it's hasOne/hasMany
					'Attachment' => array(),
				),
				// finds hasAndBelongsToMany (but no recursion)
				'Tag' => array(),
			)
		);

		// set to not-recursive
		$this->Article->Behaviors->Copyable->settings['Article'] = array(
			'recursive' => false,
			'habtm' => true,
		);

		// no settings -- generate it
		$this->assertEquals(
			$this->Article->copyGenerateContain(),
			array(
				// ignores belongsTo
				// ignores hasOne
				// ignores hasMany
				// finds hasAndBelongsToMany (but no recursion)
				'Tag' => array(),
			)
		);

		// set to not-recursive & not-habtm
		$this->Article->Behaviors->Copyable->settings['Article'] = array(
			'recursive' => false,
			'habtm' => false,
		);

		// no settings -- generate it
		$this->assertEquals(
			$this->Article->copyGenerateContain(),
			array(
				// ignores belongsTo
				// ignores hasOne
				// ignores hasMany
				// ignores hasAndBelongsToMany (but no recursion)
			)
		);
	}

/**
 * test copyableFindData() uses the settings/contain to find a record
 * and all children (in Containable hierarchy)
 *
 * @return void
 */
	public function testCopyFindData() {
		$this->assertEquals(
			$this->Article->copyFindData(1),
			$this->expectedFromFixtures[0]
		);
	}

/**
 * test preparation of data for empty values
 *
 * @return void
 */
	public function testCopyPrepareDataEmpties() {
		$this->assertEquals(
			$this->Article->copyPrepareData(array()),
			array()
		);
		$this->assertEquals(
			$this->Article->copyPrepareData(null),
			array()
		);
		$this->assertEquals(
			$this->Article->copyPrepareData(false),
			array()
		);
	}

/**
 * test preparation of data for full, nested values
 *
 * @return void
 */
	public function testCopyPrepareData1() {
		$data = $this->expectedFromFixtures[1];
		$result = $this->Article->copyPrepareData($data);
		$expected = array(
			'Article' => array(
				'user_id' => '3',
				'title' => 'Second Article',
				'body' => 'Second Article Body',
				'published' => 'Y',
				'updated' => '2007-03-18 10:43:31',
			),
			// strips User (belongsTo)
			'Featured' => array(
				'category_id' => '1',
				'published_date' => '2007-03-31 10:39:23',
				'end_date' => '2007-05-15 10:39:23',
				'updated' => '2007-03-18 10:41:31',
				// strips ArticleFeatured (belongsTo)
			),
			'Comment' => array(
				0 => array(
					'user_id' => '1',
					'comment' => 'First Comment for Second Article',
					'published' => 'Y',
					'updated' => '2007-03-18 10:55:31',
					// strips User (belongsTo)
				),
				1 => array(
					'user_id' => '2',
					'comment' => 'Second Comment for Second Article',
					'published' => 'Y',
					'updated' => '2007-03-18 10:57:31',
					// strips User (belongsTo)
				),
			),
			// HABTM switched to just the primary keys for Joins
			'Tag' => array(
				'Tag' => array(
					0 => '1',
					1 => '3',
				),
			),
		);
		$this->assertEquals($expected, $result);
	}

/**
 * test preparation of data for full, nested values - with HABTM via With
 *
 * @return void
 */
	public function testCopyPrepareDataHABTMViaWith() {
		$this->Article->bindModel(
			array(
				'hasMany' => array(
					'ArticlesWidget' => array()
				),
				'hasAndBelongsToMany' => array(
					'Widget' => array('with' => 'ArticlesWidget')
				),
			),
			false
		);
		$this->Article->ArticlesWidget->bindModel(
			array(
				'belongsTo' => array(
					'Article' => array(),
					'Widget' => array(),
				),
			),
			false
		);
		$this->Article->Widget->bindModel(
			array(
				'hasMany' => array(
					'ArticlesWidget' => array(),
				),
			),
			false
		);
		$before = $this->Article->find('first', array(
			'contain' => array(
				'Widget',
				'Widget.ArticlesWidget',
			),
			'recursive' => -1,
		));
		$this->assertEquals(
			$before,
			array(
				'Article' => array(
					'id' => '1',
					'user_id' => '1',
					'title' => 'First Article',
					'body' => 'First Article Body',
					'published' => 'Y',
					'created' => '2007-03-18 10:39:23',
					'updated' => '2007-03-18 10:41:31'
				),
				'Widget' => array(
					(int) 0 => array(
						'id' => '1',
						'name' => 'Widget 1',
						'ArticlesWidget' => array(
							'id' => '1',
							'article_id' => '1',
							'widget_id' => '1',
							'order' => '1',
							'status' => 'good',
							(int) 0 => array(
								'id' => '1',
								'article_id' => '1',
								'widget_id' => '1',
								'order' => '1',
								'status' => 'good'
							)
						)
					),
					(int) 1 => array(
						'id' => '2',
						'name' => 'Widget 2',
						'ArticlesWidget' => array(
							'id' => '2',
							'article_id' => '1',
							'widget_id' => '2',
							'order' => '2',
							'status' => 'maybe',
							(int) 0 => array(
								'id' => '2',
								'article_id' => '1',
								'widget_id' => '2',
								'order' => '2',
								'status' => 'maybe'
							)
						)
					),
					(int) 2 => array(
						'id' => '3',
						'name' => 'Widget 3',
						'ArticlesWidget' => array(
							'id' => '3',
							'article_id' => '1',
							'widget_id' => '3',
							'order' => '3',
							'status' => 'bad',
							(int) 0 => array(
								'id' => '3',
								'article_id' => '1',
								'widget_id' => '3',
								'order' => '3',
								'status' => 'bad'
							)
						)
					)
				)
			)
		);
		$result = $this->Article->copyPrepareData($before);
		$expected = array(
			'Article' => array(
				'user_id' => '1',
				'title' => 'First Article',
				'body' => 'First Article Body',
				'published' => 'Y',
				'updated' => '2007-03-18 10:41:31'
			),
			// handles as hasMany (nested)
			'ArticlesWidget' => array(
				array(
					'widget_id' => '1',
					'order' => '1',
					'status' => 'good',
					(int) 0 => array(
						'id' => '1',
						'article_id' => '1',
						'widget_id' => '1',
						'order' => '1',
						'status' => 'good'
					)
				),
				array(
					'widget_id' => '2',
					'order' => '2',
					'status' => 'maybe',
					(int) 0 => array(
						'id' => '2',
						'article_id' => '1',
						'widget_id' => '2',
						'order' => '2',
						'status' => 'maybe'
					)
				),
				array(
					'widget_id' => '3',
					'order' => '3',
					'status' => 'bad',
					(int) 0 => array(
						'id' => '3',
						'article_id' => '1',
						'widget_id' => '3',
						'order' => '3',
						'status' => 'bad'
					)
				)
			),
		);
		$this->assertEquals($expected, $result);
	}

/**
 * test preparation of data for full, nested values - with HABTM via With as hasMany
 *
 * @return void
 */
	public function testCopyPrepareDataHABTMViaWithAsHasMany() {
		$this->Article->bindModel(
			array(
				'hasMany' => array(
					'ArticlesWidget' => array()
				),
				'hasAndBelongsToMany' => array(
					'Widget' => array('with' => 'ArticlesWidget')
				),
			),
			false
		);
		$this->Article->ArticlesWidget->bindModel(
			array(
				'belongsTo' => array(
					'Article' => array(),
					'Widget' => array(),
				),
			),
			false
		);
		$before = $this->Article->find('first', array(
			'contain' => array(
				'ArticlesWidget',
				'ArticlesWidget.Widget',
			),
			'recursive' => -1,
		));
		$this->assertEquals(
			$before,
			array(
				'Article' => array(
					'id' => '1',
					'user_id' => '1',
					'title' => 'First Article',
					'body' => 'First Article Body',
					'published' => 'Y',
					'created' => '2007-03-18 10:39:23',
					'updated' => '2007-03-18 10:41:31'
				),
				'ArticlesWidget' => array(
					array(
						'id' => '1',
						'article_id' => '1',
						'widget_id' => '1',
						'order' => '1',
						'status' => 'good',
						'Widget' => array(
							'id' => '1',
							'name' => 'Widget 1'
						)
					),
					array(
						'id' => '2',
						'article_id' => '1',
						'widget_id' => '2',
						'order' => '2',
						'status' => 'maybe',
						'Widget' => array(
							'id' => '2',
							'name' => 'Widget 2'
						)
					),
					array(
						'id' => '3',
						'article_id' => '1',
						'widget_id' => '3',
						'order' => '3',
						'status' => 'bad',
						'Widget' => array(
							'id' => '3',
							'name' => 'Widget 3'
						)
					)
				)
			)
		);
		$result = $this->Article->copyPrepareData($before);
		$expected = array(
			'Article' => array(
				'user_id' => '1',
				'title' => 'First Article',
				'body' => 'First Article Body',
				'published' => 'Y',
				'updated' => '2007-03-18 10:41:31'
			),
			// handles as hasMany (nested)
			'ArticlesWidget' => array(
				array(
					'widget_id' => '1',
					'order' => '1',
					'status' => 'good',
				),
				array(
					'widget_id' => '2',
					'order' => '2',
					'status' => 'maybe',
				),
				array(
					'widget_id' => '3',
					'order' => '3',
					'status' => 'bad',
				)
			)
		);
		$this->assertEquals($expected, $result);
	}

/**
 * test copy save all
 * - does save all, but no convert/prepare of data
 * - does _updateMasterKey
 *
 * @return void
 */
	public function testCopySaveAll() {
		$initialCounts = array(
			'Article' => $this->Article->find('count'),
			'User' => $this->Article->User->find('count'),
			'Featured' => $this->Article->Featured->find('count'),
			'Comment' => $this->Article->Comment->find('count'),
			'Tag' => $this->Article->Tag->find('count'),
		);
		$before = $this->Article->copyFindData(1);
		$save = $before;
		unset($save['Tag']);
		$saved = $this->Article->copySaveAll($save);
		$this->assertTrue($saved);

		$id = $this->Article->id;
		$this->assertEquals($id, 1);

		$after = $this->Article->copyFindData(1);
		$this->assertEquals($before, $after);

		$this->assertEquals(
			array(
				'Article' => $this->Article->find('count'),
				'User' => $this->Article->User->find('count'),
				'Featured' => $this->Article->Featured->find('count'),
				'Comment' => $this->Article->Comment->find('count'),
				'Tag' => $this->Article->Tag->find('count'),
			),
			$initialCounts
		);
	}

/**
 * test copy on fixture Article#1
 *
 * @return void
 */
	public function testCopy1() {
		$initialCounts = array(
			'Article' => $this->Article->find('count'),
			'User' => $this->Article->User->find('count'),
			'Featured' => $this->Article->Featured->find('count'),
			'Comment' => $this->Article->Comment->find('count'),
			'Tag' => $this->Article->Tag->find('count'),
		);

		$result = $this->Article->copy(1);
		$this->assertTrue($result);

		$newId = $this->Article->id;
		$this->assertTrue(is_numeric($newId));

		// orig is unchanged
		$result = $this->Article->find('first', array(
			'contain' => $this->settings['containArticle'],
			'conditions' => array(
				'Article.id' => 1
			)
		));
		$expected = $this->expectedFromFixtures[0];
		$this->assertEquals($expected, $result);

		// see how many records were created
		$this->assertEquals(
			$this->Article->find('count'),
			$initialCounts['Article'] + 1
		);
		$this->assertEquals(
			$this->Article->User->find('count'),
			$initialCounts['User']
		);
		$this->assertEquals(
			$this->Article->Featured->find('count'),
			$initialCounts['Featured'] + 1
		);
		$this->assertEquals(
			$this->Article->Comment->find('count'),
			$initialCounts['Comment'] + 4
		);
		// should not have made any more HABTM targets
		//   should only have made more join records
		$this->assertEquals(
			$this->Article->Tag->find('count'),
			$initialCounts['Tag']
		);

		// new record
		$result = $this->Article->find('first', array(
			'contain' => $this->settings['containArticle'],
			'conditions' => array(
				'Article.id' => $newId
			)
		));
		$this->_assertArticleAfterCopy($result, $expected);
	}

/**
 * test copy on fixture Article#2
 *
 * @return void
 */
	public function testCopy2() {
		$initialCounts = array(
			'Article' => $this->Article->find('count'),
			'User' => $this->Article->User->find('count'),
			'Featured' => $this->Article->Featured->find('count'),
			'Comment' => $this->Article->Comment->find('count'),
			'Tag' => $this->Article->Tag->find('count'),
		);

		$result = $this->Article->copy(2);
		$this->assertTrue($result);

		$newId = $this->Article->id;
		$this->assertTrue(is_numeric($newId));

		// orig is unchanged
		$result = $this->Article->find('first', array(
			'contain' => $this->settings['containArticle'],
			'conditions' => array(
				'Article.id' => 2
			)
		));
		$expected = $this->expectedFromFixtures[1];
		$this->assertEquals($expected, $result);

		// see how many records were created
		$this->assertEquals(
			$this->Article->find('count'),
			$initialCounts['Article'] + 1
		);
		$this->assertEquals(
			$this->Article->User->find('count'),
			$initialCounts['User']
		);
		$this->assertEquals(
			$this->Article->Featured->find('count'),
			$initialCounts['Featured'] + 1
		);
		$this->assertEquals(
			$this->Article->Comment->find('count'),
			$initialCounts['Comment'] + 2
		);
		// should not have made any more HABTM targets
		//   should only have made more join records
		$this->assertEquals(
			$this->Article->Tag->find('count'),
			$initialCounts['Tag']
		);

		// new record
		$result = $this->Article->find('first', array(
			'contain' => $this->settings['containArticle'],
			'conditions' => array(
				'Article.id' => $newId
			)
		));
		$this->_assertArticleAfterCopy($result, $expected);
	}

/**
 * test copy on fixture Article#3
 *
 * @return void
 */
	public function testCopy3() {
		$initialCounts = array(
			'Article' => $this->Article->find('count'),
			'User' => $this->Article->User->find('count'),
			'Featured' => $this->Article->Featured->find('count'),
			'Comment' => $this->Article->Comment->find('count'),
			'Tag' => $this->Article->Tag->find('count'),
		);

		$result = $this->Article->copy(3);
		$this->assertTrue($result);

		$newId = $this->Article->id;
		$this->assertTrue(is_numeric($newId));

		// orig is unchanged
		$result = $this->Article->find('first', array(
			'contain' => $this->settings['containArticle'],
			'conditions' => array(
				'Article.id' => 3
			)
		));
		$expected = $this->expectedFromFixtures[2];
		$this->assertEquals($expected, $result);

		// see how many records were created
		$this->assertEquals(
			$this->Article->find('count'),
			$initialCounts['Article'] + 1
		);
		$this->assertEquals(
			$this->Article->User->find('count'),
			$initialCounts['User']
		);
		$this->assertEquals(
			$this->Article->Featured->find('count'),
			$initialCounts['Featured']
		);
		$this->assertEquals(
			$this->Article->Comment->find('count'),
			$initialCounts['Comment']
		);
		$this->assertEquals(
			$this->Article->Tag->find('count'),
			$initialCounts['Tag']
		);
		$this->_assertArticleAfterCopy($result, $expected);
	}

/**
 * test copy on fixture Article#1 with inject data to overwrite after prep.
 *
 * @return void
 */
	public function testCopyWithInjectionData() {
		$initialCounts = array(
			'Article' => $this->Article->find('count'),
			'User' => $this->Article->User->find('count'),
			'Featured' => $this->Article->Featured->find('count'),
			'Comment' => $this->Article->Comment->find('count'),
			'Tag' => $this->Article->Tag->find('count'),
		);

		$customSettings = array(
			'merge' => array(
				'Article' => array(
					'title' => 'INJECT changed this',
					'published' => 'X',
				)
			),
			'insert' => array(
				'Comment.{n}.user_id' => 0,
				'Comment.{n}.comment' => 'INJECT changed via Hash::insert()',
			),
		);
		$result = $this->Article->copy(1, $customSettings);
		$this->assertTrue($result);

		$newId = $this->Article->id;
		$this->assertTrue(is_numeric($newId));

		// orig is unchanged
		$result = $this->Article->find('first', array(
			'contain' => $this->settings['containArticle'],
			'conditions' => array(
				'Article.id' => 1
			)
		));

		$expected = $this->expectedFromFixtures[0];
		$this->assertEquals($expected, $result);

		// see how many records were created
		$this->assertEquals(
			$this->Article->find('count'),
			$initialCounts['Article'] + 1
		);
		$this->assertEquals(
			$this->Article->User->find('count'),
			$initialCounts['User']
		);
		$this->assertEquals(
			$this->Article->Featured->find('count'),
			$initialCounts['Featured'] + 1
		);
		$this->assertEquals(
			$this->Article->Comment->find('count'),
			$initialCounts['Comment'] + 4
		);
		// should not have made any more HABTM targets
		//   should only have made more join records
		$this->assertEquals(
			$this->Article->Tag->find('count'),
			$initialCounts['Tag']
		);

		// new record
		$result = $this->Article->find('first', array(
			'contain' => $this->settings['containArticle'],
			'conditions' => array(
				'Article.id' => $newId
			)
		));

		// Inject changed expectations via Hash::merge()
		$expected['Article']['title'] = $customSettings['merge']['Article']['title'];
		$expected['Article']['published'] = $customSettings['merge']['Article']['published'];
		// Inject changed expectations via Hash::insert()
		foreach ($expected['Comment'] as $i => $data) {
			$expected['Comment'][$i]['user_id'] = $customSettings['insert']['Comment.{n}.user_id'];
			$expected['Comment'][$i]['comment'] = $customSettings['insert']['Comment.{n}.comment'];
		}
		$this->_assertArticleAfterCopy($result, $expected);
	}



/**
 * custom assertion helper
 *
 */
	public function _assertArticleAfterCopy($result, $expected) {
		// verify self
		$fields = array(
			'title',
			'body',
			'published',
			'published_date',
		);
		foreach ($fields as $field) {
			$this->assertEquals(
				Hash::extract($result, "Article.$field"),
				Hash::extract($expected, "Article.$field"),
				"self Article.$field should match expected"
			);
		}

		// verify belongsTo
		if (!(empty($result['User']) && empty($expected['User']))) {
			$this->assertEquals(
				Hash::extract($result, 'User.id'),
				Hash::extract($expected, 'User.id'),
				'belongsTo User.id should match expected (no new record)'
			);
			$this->assertEquals(
				Hash::extract($result, 'User.user'),
				Hash::extract($expected, 'User.user'),
				'belongsTo User.user should match expected (no new record)'
			);
		}

		// verify hasOne
		if (!(empty($result['Featured']['id']) && empty($expected['Featured']['id']))) {
			$this->assertNotEquals(
				Hash::extract($result, 'Featured.id'),
				Hash::extract($expected, 'Featured.id'),
				'hasOne Featured.id should not match expected'
			);
			$this->assertEquals(
				Hash::extract($result, 'Featured.category_id'),
				Hash::extract($expected, 'Featured.category_id'),
				'hasOne Featured.category_id should match expected'
			);
			$this->assertEquals(
				Hash::extract($result, 'Featured.published_date'),
				Hash::extract($expected, 'Featured.published_date'),
				'hasOne Featured.published_date should match expected'
			);
		}

		// verify hasMany
		if (!(empty($result['Comment']) && empty($expected['Comment']))) {
			$this->assertNotEquals(
				Hash::extract($result, 'Comment.{n}.id'),
				Hash::extract($expected, 'Comment.{n}.id'),
				'hasMany Comment.{n}.id should not match expected'
			);
			$this->assertEquals(
				Hash::extract($result, 'Comment.{n}.comment'),
				Hash::extract($expected, 'Comment.{n}.comment'),
				'hasMany Comment.{n}.comment should match expected'
			);
			$this->assertEquals(
				Hash::extract($result, 'Comment.{n}.user_id'),
				Hash::extract($expected, 'Comment.{n}.user_id'),
				'hasMany Comment.{n}.user_id should match expected'
			);
			$this->assertEquals(
				Hash::extract($result, 'Comment.{n}.published'),
				Hash::extract($expected, 'Comment.{n}.published'),
				'hasMany Comment.{n}.published should match expected'
			);
		}

		// verify HABTM
		if (!(empty($result['Tag']) && empty($expected['Tag']))) {
			$this->assertEquals(
				Hash::extract($result, 'Tag.{n}.id'),
				Hash::extract($expected, 'Tag.{n}.id'),
				'HABTM Tag.{n}.id should match expected (join table is the only new record)'
			);
			$this->assertEquals(
				Hash::extract($result, 'Tag.{n}.tag'),
				Hash::extract($expected, 'Tag.{n}.tag'),
				'HABTM Tag.{n}.tag should match expected'
			);
		}
	}


}
