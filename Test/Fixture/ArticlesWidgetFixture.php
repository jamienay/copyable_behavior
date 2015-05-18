<?php
/**
 * Copyable Test Fixture
 *
 * PHP Version 5.4+
 *
 */
class ArticlesWidgetFixture extends CakeTestFixture {

/**
 * Name
 *
 * @var string
 * @access public
 */
	public $name = 'ArticlesWidget';

/**
 * Fields
 *
 * @var array
 * @access public
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'article_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'widget_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'order' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'status' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'article_id' => array('column' => array('article_id', 'status'), 'unique' => 0)
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
			'article_id' => 1,
			'widget_id' => 1,
			'order' => 1,
			'status' => 'good',
		),
		array(
			'id' => 2,
			'article_id' => 1,
			'widget_id' => 2,
			'order' => 2,
			'status' => 'maybe',
		),
		array(
			'id' => 3,
			'article_id' => 1,
			'widget_id' => 3,
			'order' => 3,
			'status' => 'bad',
		),
	);

}
