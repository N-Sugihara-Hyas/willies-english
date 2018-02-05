<?php
/*
*	トピックスリストの読み込み
*/
	$this->addModel(array('take/ScheduleView'));

	$this->getCommon();

	$arraySet = $this->TakeScheduleView->setView($this->arrayAll);

	foreach ($arraySet as $key => $item){
		$this->set($key, $item);
	}

	$this->set('allView', getVar($this->arrayAll, 'allView'));
	$this->set('isNotView', getVar($this->arrayAll, 'isNotView'));
	$this->set('isChange', getVar($this->arrayAll, 'isChange'));
?>