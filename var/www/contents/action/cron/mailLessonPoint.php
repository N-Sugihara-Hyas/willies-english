<?php

	/*
	*	休日の場合の振替ポイント
	*/
	$this->addModel(array('member/Base', 'take/Reserve'));


	$this->MemberBase->target = '*,member_base.*';
	$this->MemberBase->joinCourceBase();
	$this->MemberBase->joinCourceStyle();
	$this->MemberBase->addQuery('weekTake IS NULL');
	$this->MemberBase->addQuery('state', 3);
	$this->MemberBase->addQuery('datePay IS NOT NULL');
	$dbGet = $this->MemberBase->getData();
	
	while ($item = $dbGet->getData()){
		echo $item['id'] . '/' . $item['datePay'] . '/';
		
		$time = strtotime(date('Y-m-d')) - strtotime($item['datePay']);
		$countLesson = intval($time / (3600 * 24 * 7)) * 2;
		echo $countLesson . '/';
		
		$this->TakeReserve->addQuery('member_base_id', $item['id']);
		echo $this->TakeReserve->getData()->getCount();
		
		echo '<br />';
	}

	exit();

?>