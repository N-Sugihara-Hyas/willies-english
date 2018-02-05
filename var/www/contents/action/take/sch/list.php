<?php
/*
*	トピックスリストの読み込み
*/
	$this->addModel(array('take/ScheduleView'));

	$this->getCommon();

	$this->arrayAll['takeName'] = $this->arrayUser['nickname'];

	$arraySet = $this->TakeScheduleView->setView($this->arrayAll);

	$this->set('isTake', true);

	foreach ($arraySet as $key => $item){
		$this->set($key, $item);
	}
?>