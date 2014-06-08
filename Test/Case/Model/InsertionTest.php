<?php
/* Insertion Test cases generated on: 2012-05-06 13:53:36 : 1336305216*/
App::uses('Insertion', 'Model');

/**
 * Insertion Test Case
 *
 */
class InsertionTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.insertion');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Insertion = ClassRegistry::init('Insertion');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Insertion);

		parent::tearDown();
	}

}
