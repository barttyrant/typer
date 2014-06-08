<?php
/* Bet Fixture generated on: 2012-06-03 01:03:27 : 1338678207 */

/**
 * BetFixture
 *
 */
class BetFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'event_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'stake' => array('type' => 'float', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'odd_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'odd' => array('type' => 'float', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'status' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 10, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'user_id' => 1,
			'event_id' => 1,
			'stake' => 1,
			'odd_id' => 1,
			'odd' => 1,
			'status' => 'Lorem ip',
			'created' => '2012-06-03 01:03:27',
			'modified' => '2012-06-03 01:03:27'
		),
	);
}
