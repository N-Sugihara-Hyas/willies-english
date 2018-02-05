<?php

	/*
	*	支払いの無い人間のコースのキャンセルの処理
	*/
	$this->addModel(array('take/Reserve', 'member/Base'));
		

	$arrayMember = $this->TakeReserve->getTryoutOver()->getDataAll();


	foreach($arrayMember as $item){
		$arrayData['id'] = $item['member_base_id'];
		//$arrayData['cource_base_id'] = 0;
		//$arrayData['cource_style_id'] = 0;
		$arrayData['cource_schedule_id'] = 0;
		$arrayData['timeStart'] = '00:00:00';
		$arrayData['timeEnd'] = '00:00:00';
		$arrayData['take_base_id'] = '0';
		$arrayData['state'] = 11;


		$this->TakeReserve->addQuery('member_base_id', $item['member_base_id']);
		$this->TakeReserve->addQuery('concat(date," ",timeStart) >=', date('Y-m-d H:i:s'));

		$this->TakeReserve->addQuery('type', 1);
		
		$this->MemberBase->commit($arrayData);

		$this->TakeReserve->delData();
	}
	
	exit();
		
?>