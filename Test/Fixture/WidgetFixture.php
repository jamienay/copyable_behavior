<?php
/**
 * Copyable Test Fixture
 *
 * PHP Version 5.4+
 *
 */
class WidgetFixture extends CakeTestFixture {

/**
 * Name
 *
 * @var string
 * @access public
 */
	public $name = 'Widget';

/**
 * Fields
 *
 * @var array
 * @access public
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 * @access public
 */
	public $records = array(
		array(
			'id' => 1,
			'name' => 'Widget 1',
		),
		array(
			'id' => 2,
			'name' => 'Widget 2',
		),
		array(
			'id' => 3,
			'name' => 'Widget 3',
		),
	);

}
