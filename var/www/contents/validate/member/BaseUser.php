<?php

require_once 'Base.php';

class ValidateMemberBaseUser extends ValidateMemberBase{

	function ValidateMemberBaseUser(){
		unset($this->validate['email']);
		unset($this->validate['emailConf']);
		unset($this->validate['selectSearch']);

	}
}

?>
