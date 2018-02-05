<?php

/***********************************************************
*	項目の削除
*/

	//共通処理
	$this->getCommon();

	//モデル情報の読み込み
	$this->addModel(array('take/UpdateZone', 'take/Update'));

	$isOK = false;

	$arrayStandby = $this->TakeUpdateZone->getStandby($this->arrayUser['id'], 20);

	//二十分以内のものは-1にする
	if ($arrayStandby){
		$arrayData['dateTime'] = $this->TakeUpdateZone->dateNow . ' ' . $arrayStandby['time'];
		$arrayData['take_base_id'] = $arrayStandby['take_base_id'];
		$arrayData['isOK'] = -1;

		$this->TakeUpdate->commit($arrayData);
		$isOK = true;
	}

	$arrayStandby = $this->TakeUpdateZone->getStandby($this->arrayUser['id']);


	if ($arrayStandby){
		$arrayData['dateTime'] = $this->TakeUpdateZone->dateNow . ' ' . $arrayStandby['time'];
		$arrayData['take_base_id'] = $arrayStandby['take_base_id'];
		$arrayData['isOK'] = 1;

		$this->TakeUpdate->commit($arrayData);
		$isOK = true;
	}

	if ($isOK){
		$this->set('ok','OK');
	}else{
		$this->set('ok','click again later 40 min before your shift starts');
	}
?>