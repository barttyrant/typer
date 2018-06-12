<?php

class UserShell extends Shell {

	public $uses = array('Odd', 'Event', 'User', 'Bet');

	public function _welcome() {

	}

	public function main() {
		die('no method called');
	}

	public function activate_new_users(){
		var_dump($this->args);
	}

	public function activate_user(){
		var_dump($this->args);
	}

}
