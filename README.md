# Recursive Copy for CakePHP

If you have a (deeply) nested tree of data, a model with several
hasMany and hasAndBelongsToMany associaitons...
you can not simply find() and then save()...

To copy, you need to clear out the ID to create the new record...
but then you have to do that for all of the associated records too.

And you have to make sure that the newly creataed associated records are in fact,
associated correctly with the new record.

## Install

```
cd path/to/app
git submodule add https://github.com/jamienay/copyable_behavior.git Plugin/Copyable
```
or
```
cd path/to/app
git clone https://github.com/jamienay/copyable_behavior.git Plugin/Copyable
```

## Configure

`app/Config/bootstrap.php`

```
	CakePlugin::load('Copyable');
```

And for every Model you want to use this on,
you will need to setup the behavior with specific settings (see Usage).

## Usage - Setup

On any Model - you must first initialize the CopyableBehavior

```
public $actsAs = array(
	'Copyable.Copyable' => array(),
);
```

You may want to customize any of the settings for this Model

```
public $actsAs = array(
	'Copyable.Copyable' => array(
		// recursive: whether to copy hasMany and hasOne records
		'recursive' => true,
		// habtm: whether to copy hasAndBelongsToMany associations
		'habtm' => true,
		// stripFields: fields to strip during copy process
		'stripFields' => array(
			'id',
			'created',
			'modified',
			'lft',
			'rght'
		),
		// ignore: aliases of any associations that should be ignored, using dot (.) notation.
		'ignore' => array(
		),
		// ?
		'masterKey' => null
	),
);
```

## Usage - Perform Copy

```
// $id = the id of the record to be copied (int or uuid)
if (!$this->MyModel->copy($id)) {
	throw new CakeException("Unable to copy {$this->MyModel->alias} #{$id}");
}
$newId = $this->MyModel->id;
```

You can pass in any and all settings at runtime like so:

```
$settings = array(
	'contain' => array('Foo', 'Foo.Bar'),
	'saveAllOptions' => array('deep' => true, 'atomic' => true, 'validate' => true, 'callbacks' => false),
	'stripFields' => array('id', 'created', 'modified', 'updated', 'my_unique_field')
);
if (!$this->MyModel->copy($id, $settings)) {
	throw new CakeException("Unable to copy {$this->MyModel->alias} #{$id} with custom settings");
}
$newId = $this->MyModel->id;
```

You can also pass in *inject setting*,
which will overwrite values after
`copyPrepareData()` but before `copySaveAll()`

This is great if you want to default/change your data for the `copy()` but don't
want to have to edit after the copy... (important for unique fields)


We support two types of injections:

* `merge` uses `Hash::merge()` to merge / overwrite basic nested arrays
  (simple, but doesn't work great for hasMany records)
* `insert` uses `Hash::insert()` to overwrite every instance matching a path
  (great for hasMany records)

```
$settings = array(
	'merge' => array(
		'MyModel' => array(
			'unique_field' => 'newValue',
			'parent_id' => $id,
			'copied_on' => date('Y-m-d H:i:s'),
			'copied_by' => $user_id,
		)
	),
	'insert' => array(
		'MyHasManyChild.{n}.field1' => null,
		'MyHasManyChild.{n}.copied_on' => date('Y-m-d H:i:s'),
		'MyHasManyChild.{n}.copied_by' => $user_id,
	)
);
if (!$this->MyModel->copy($id, $settings)) {
	throw new CakeException("Unable to copy {$this->MyModel->alias} #{$id} with injected data");
}
$newId = $this->MyModel->id;
```


### Public Methods:

```
 * Primary Public Method:
 *   copy($id, $settings)     --> $saved
 *
 * Secondary Public Methods:
 *   copyGenerateContain()    --> $contain (from settings, or generated)
 *   copyFindData($id)        --> $record    (find first w/ contains)
 *   copyPrepareData($record) --> $record    (convert data w/o foreignKey/stripFields)
 *   copySaveAll($record)     --> $saved   (do saveAll and update masterKey)
```

## Background Information

Adds recursive record copying to CakePHP
For more information:
http://jamienay.com/2010/03/copyable-behavior-for-cakephp-1-3-recursive-record-copying
