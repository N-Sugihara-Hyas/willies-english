<?php

	/*
	*	一時間後のレッスンを控えてる人間を取得
	*/
	$this->addModel(array('take/Reserve'));
	
	$time = time() + 3600;
	$date = date('Y-m-d', $time);
	

	
	if (date('i') >= 30){
		$time = date('H:30:00', $time);	
	}else{
		$time = date('H:00:00', $time);
	}
	
	$this->TakeReserve->target = '*,take_reserve.*,member_base.email,member_base.memberNameSecound,member_base.memberNameFirst';
	$this->TakeReserve->joinMemberBase();
	$this->TakeReserve->joinTakeBase();		
	
	$this->TakeReserve->addQuery('isMail IS NULL');
	$dbGet = $this->TakeReserve->getScheduleDate($date , $time);

	$this->TakeReserve->addModelTool('Mail');
	while($item = $dbGet->getData()){
		

		$arrayCommit['id'] = $item['id'];
		$arrayCommit['isMail'] = 1;
		
		$this->TakeReserve->commit($arrayCommit);
		
		$this->TakeReserve->arrayData = $item;

		$this->TakeReserve->arrayData['time'] = $item['timeStart'];
		$this->TakeReserve->arrayData['takeName'] = $item['nickname'];
		$this->TakeReserve->arrayData['skypeID'] = $item['skypeID'];
		
		$this->TakeReserve->arrayData['domain'] = $arraySetting['domain'];
		$this->TakeReserve->mailSend(7, array($item['email']));
	}
	
	exit();
		
?>