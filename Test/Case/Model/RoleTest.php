<?php
/* Role Test cases generated on: 2012-05-06 13:53:56 : 1336305236*/
App::uses('Role', 'Model');

/**
 * Role Test Case
 *
 */
class RoleTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.role', 'app.user');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Role = ClassRegistry::init('Role');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Role);

		parent::tearDown();
	}

}
