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
if (!$this->MyModel->copy($id)) {
	throw new CakeException("Unable to copy {$this->MyModel->alias} #{$id}");
}
$newId = $this->MyModel->id;
```

$id = the id of the record to be copied (int or uuid)

### Primary Public Method:

```
*   copy($id, $settings)   --> $saved
```


### Secondary Public Methods:

```
*   copyGenerateContain()  --> $contain (from settings, or generated)
*   copyFindData($id)      --> $data    (find first w/ contains)
*   copyPrepareData($data) --> $data    (convert data w/o foreignKey/stripFields)
*   copySaveAll($data)     --> $saved   (do saveAll and update masterKey)
```

## Background Information

Adds recursive record copying to CakePHP
For more information:
http://jamienay.com/2010/03/copyable-behavior-for-cakephp-1-3-recursive-record-copying
