<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array('take/Schedule', 'take/Base'));

		//共通処理
		$this->getCommon();

		$arrayTime = $this->TakeSchedule->getArrayTime();
		

		if (isset($this->arrayAll['reflash'])){
			$this->TakeSchedule->reflash($this->uid, $this->arrayPost['week']);

			$this->set('reflash', 1);
						
			$this->TakeSchedule->reflashBlock($this->uid);
			$this->TakeSchedule->reflashUpdateZone($this->uid);
		}

		
		$this->set('arrayTakeBase', $this->TakeBase->getDataUID($this->uid)->getData());		
		$this->set('arrayTakeSchedule', $this->TakeSchedule->getDataTake($this->uid));

		$this->set('arrayWeek', $this->TakeSchedule->getFunctionData('Week'));
		$this->set('arrayTime', $arrayTime);
		$this->set('uid', $this->uid);
		$this->set('redirect', urlencode(urldecode($this->arrayAll['redirect'])));
		$this->set('link', urldecode($this->arrayAll['redirect']));

?>