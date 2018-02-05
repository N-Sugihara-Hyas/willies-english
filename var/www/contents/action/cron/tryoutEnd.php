<?php

	/*
	*	支払いの無い人間の体験終了の処理
	*/
	$this->addModel(array('member/Base'));
		

	$dbGet = $this->MemberBase->getTrioutEnd();

	
	while($item = $dbGet->getData()){
		$item['state'] = 2;
		$this->MemberBase->setStatus($item);

		/*$this->MemberBase->addQuery('id', $item['id']);

		$arraySet['cource_base_id'] = 0;
		$arraySet['cource_style_id'] = 0;
		$arraySet['cource_schedule_id'] = 0;
		$arraySet['take_base_id'] = 0;

		$this->MemberBase->setData($arraySet);*/
	}
	
	exit();
		
?>