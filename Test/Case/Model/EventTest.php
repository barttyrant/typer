<?php
/* Event Test cases generated on: 2012-06-03 01:03:37 : 1338678217*/
App::uses('Event', 'Model');

/**
 * Event Test Case
 *
 */
class EventTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.event', 'app.bet', 'app.user', 'app.odd');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Event = ClassRegistry::init('Event');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Event);

		parent::tearDown();
	}

}
