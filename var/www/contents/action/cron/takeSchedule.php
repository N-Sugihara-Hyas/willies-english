<?php

	/*
	*	講師のスケジュールの再追加
	*/
	$this->addModel(array('take/Schedule'));


	$this->TakeSchedule->reflashBlock();
?>