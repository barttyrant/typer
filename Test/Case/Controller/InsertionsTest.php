<?php
/* Insertions Test cases generated on: 2012-05-06 14:32:51 : 1336307571*/
App::uses('Insertions', 'Controller');

/**
 * TestInsertions *
 */
class TestInsertions extends Insertions {
/**
 * Auto render
 *
 * @var boolean
 */
	public $autoRender = false;

/**
 * Redirect action
 *
 * @param mixed $url
 * @param mixed $status
 * @param boolean $exit
 * @return void
 */
	public function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

/**
 * Insertions Test Case
 *
 */
class InsertionsTestCase extends CakeTestCase {
/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Insertions = new TestInsertions();
		$this->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Insertions);

		parent::tearDown();
	}

}
