<?php
/*
*	トピックスリストの読み込み
*/
	$this->addModel(array('take/ScheduleView', 'take/Base', 'take/Reserve', 'take/Schedule', 'take/Cancel', 'cource/Style'));

	$this->getCommon();
	
	$arraySet = $this->TakeScheduleView->setView($this->arrayAll);

	foreach ($arraySet as $key => $item){
		$this->set($key, $item);
	}

	//カウンターの取得
	$takeName = getVar($this->arrayAll, 'takeName');

	//日時
	if (!empty($this->arrayAll['dateStart'])){
		$dateStart = $this->arrayAll['dateStart'];
	}else{
		$dateStart = date('Y-m-d');
	}
	if (!empty($this->arrayAll['dateEnd'])){
		$dateEnd = $this->arrayAll['dateEnd'];
	}else{
		$dateEnd = date('Y-m-d');
	}

	$timeStart = strtotime($dateStart . ' 00:00:00');
	$timeEnd = strtotime($dateEnd . ' 23:59:59');

	if ($takeName){
		$this->TakeBase->addQuery('nickname', $takeName);
	}

	$arrayTakeBase = $this->TakeBase->getData()->getDataAll();
		
	$arrayPay = array();
	foreach ($arrayTakeBase as $objTake){
		$arrayPay[$objTake['id']] = $this->TakeReserve->getCounter(strtotime($dateStart), strtotime($dateEnd), $objTake);
		$arrayPay[$objTake['id']]['objTake'] = $objTake;
	}
		
	$this->set('arrayType', $this->TakeReserve->arrayTypeCourse);
	$this->set('arrayPayTotal', $this->TakeReserve->arrayPayTotal);
	$this->set('arrayPay', $arrayPay);
	$this->set('isNotView', getVar($this->arrayAll, 'isNotView'));
	$this->set('isChange', getVar($this->arrayAll, 'isChange'));
	$this->set('isCounter', 1);

?>