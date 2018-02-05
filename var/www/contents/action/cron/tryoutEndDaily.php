<?php

	/*
	*	支払いの無い人間の体験終了の処理
	*/
	$this->addModel(array('member/Base'));
		

	$dbGet = $this->MemberBase->getTrioutEndDaily();

	
	while($item = $dbGet->getData()){
		$item['stateDaily'] = 2;
		$this->MemberBase->setStatusDaily($item);
	}
	
	exit();
		
?>