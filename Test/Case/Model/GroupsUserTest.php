<?php
/* GroupsUser Test cases generated on: 2012-05-06 13:53:21 : 1336305201*/
App::uses('GroupsUser', 'Model');

/**
 * GroupsUser Test Case
 *
 */
class GroupsUserTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.groups_user', 'app.group', 'app.user');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->GroupsUser = ClassRegistry::init('GroupsUser');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->GroupsUser);

		parent::tearDown();
	}

}
