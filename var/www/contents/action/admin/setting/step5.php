<?php
/*
*	初期設定画面2
*/

		//モデル情報の読み込み
		$this->addModel(array('cource/Base', 'cource/Style', 'member/Setting', 'setting/Meta', 'take/Schedule', 'take/Reserve'));
		$this->addLiblary(array('inoutput/Date'));

		$this->getCommon('first');


		if (!$arrayData = $this->MemberSetting->getSettingStep(4, $this->arrayAll)){
			$this->setRedirect('mypage/setting/step4/?error=1');
		}


		//受講プランの選択肢の取得
		$arrayCourceStyle = $this->CourceStyle->getDataUID($arrayData['csID'])->getData();

		//全ての受講曜日の取得
		$arrayDate = $this->TakeSchedule->getWeekData($arrayData['dateFirst'], $arrayData['cshID'], $arrayData['cID']);

		$arraySchedule = $this->TakeSchedule->getFunctionData('Schedule');
		$arraySchedule = $arraySchedule[$arrayData['cshID']];


		$this->TakeReserve->joinTakeBase();
		$arrayCourceSchedule = $this->TakeReserve->getDataTime($arrayData['cID'], $arrayDate, $arrayData['time'], $arrayCourceStyle['weekTime'], 1);


		$this->set('timeNow', $arrayData['time']);
		$this->set('arraySchedule', $arraySchedule);

		$this->set('arrayCourceBase', $this->CourceBase->getDataUID($arrayData['cID'])->getData());
		$this->set('arrayCourceSchedule', $arrayCourceSchedule);

		$this->set('arrayWeek', array('日', '月', '火', '水', '木', '金', '土'));
		$this->set('dateFirst', $arrayData['dateFirst']);

		$this->MemberSetting->setSession('levelChild', '');

?>