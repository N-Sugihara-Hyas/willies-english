<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array('take/Base', 'take/Schedule'));

		//共通処理
		$this->getCommon();

		$dbGet = $this->TakeBase->getData();

		while ($item = $dbGet->getData()){
			$this->TakeSchedule->reflashUpdateZone($item['id']);
		}

		exit();

?>