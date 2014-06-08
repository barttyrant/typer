<?php
/* Odd Test cases generated on: 2012-06-03 01:03:47 : 1338678227*/
App::uses('Odd', 'Model');

/**
 * Odd Test Case
 *
 */
class OddTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.odd', 'app.event', 'app.bet', 'app.user');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Odd = ClassRegistry::init('Odd');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Odd);

		parent::tearDown();
	}

}
