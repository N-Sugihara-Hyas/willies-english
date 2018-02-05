<?php
/*
*	初期設定画面2
*/

		//モデル情報の読み込み
		$this->addModel(array('cource/Base', 'cource/Style', 'member/Setting', 'setting/Meta', 'take/Base', 'take/Schedule'));

		$this->getCommon('first');

		if (!$arrayData = $this->MemberSetting->getSettingStep(6, $this->arrayAll) ){
			$this->setRedirect('mypage/setting/step5/?error=1');
		}



		//全ての受講曜日の取得
		$arrayDate = $this->TakeSchedule->getWeekData($arrayData['dateFirst'], $arrayData['cshID']);


		$this->set('arrayCourceBase', $this->CourceBase->getDataUID($arrayData['cID'])->getData());
		$this->set('arrayCourceStyle', $this->CourceStyle->getDataUID($arrayData['csID'])->getData());
		$this->set('scheduleWeek', $this->CourceStyle->getFunctionDataOwn('Schedule', $arrayData['cshID']));
		$this->set('scheduleTime', $arrayData['time']);
		$this->set('arrayTake', $this->TakeBase->getDataUID($arrayData['tID'])->getData());
		$this->set('arrayDate', $arrayDate);

		$this->set('levelChild', $this->MemberSetting->getFunctionDataOwn('LevelChild', $arrayData['levelChild']));


?>