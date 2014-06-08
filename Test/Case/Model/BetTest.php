<?php
/* Bet Test cases generated on: 2012-06-03 01:03:27 : 1338678207*/
App::uses('Bet', 'Model');

/**
 * Bet Test Case
 *
 */
class BetTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.bet', 'app.user', 'app.event', 'app.odd');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Bet = ClassRegistry::init('Bet');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Bet);

		parent::tearDown();
	}

}
