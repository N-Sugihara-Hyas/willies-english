<?php

	$this->getCommon('first');
	$this->MemberBase->addModelTool('Login');
	$this->MemberBase->logout();
		
	$this->setRedirect('login');

?>