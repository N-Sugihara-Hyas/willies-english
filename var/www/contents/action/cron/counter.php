<?php
	/ini_set('display_errors', 'On');
	error_reporting(E_ALL);

	/*
	*	講師のスケジュールの再追加
	*/
	$this->addModel(array('take/Reserve'));

	$this->TakeReserve->target = 'take_reserve.*';
	$this->TakeReserve->joinMemberBase();
	$dbGet = $this->TakeReserve->getData();

	print_r($dbGet->getData());

?>