<?php

	/*
	*	支払いの無い人間のコースのキャンセルの処理
	*/
	$this->addModel(array('take/Base', 'take/UpdateZone'));
		
	$dbGet = $this->TakeBase->getData();

	while ($item = $dbGet->getData()){
		$this->TakeUpdateZone->getOver($item['id']);
	}

	exit();
		
?>