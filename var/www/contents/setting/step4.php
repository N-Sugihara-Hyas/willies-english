<?php
/*
*	初期設定画面2
*/

		//モデル情報の読み込み
		$this->addModel(array('cource/Style', 'member/Setting', 'setting/Meta', 'take/Schedule', 'take/Reserve'));
		$this->addLiblary(array('inoutput/Date'));

		$this->getCommon('first');

		if (!$arrayData = $this->MemberSetting->getSettingStep(3, $this->arrayAll) ){
			$this->setRedirect('mypage/setting/step3/?error=1');
		}
		

		//受講プランの選択肢の取得
		$arrayCourceStyle = $this->CourceStyle->getDataUID($arrayData['csID'])->getData();

		//全ての受講曜日の取得
		$arrayDate = $this->TakeSchedule->getWeekData($arrayData['dateFirst'], $arrayData['cshID'], $arrayData['cID']);

		$arraySchedule = $this->TakeSchedule->getFunctionData('Schedule');
		$arraySchedule = $arraySchedule[$arrayData['cshID']];
		
		$arrayCourceSchedule = $this->TakeReserve->getDataDate($arrayData['cID'], $arrayDate, $arrayCourceStyle['weekTime'], 1);
		

		$this->set('arraySchedule', $arraySchedule);
		$this->set('arrayCourceSchedule', $arrayCourceSchedule);

		$this->set('arrayWeek', array('日', '月', '火', '水', '木', '金', '土'));
		$this->set('dateFirst', $arrayData['dateFirst']);

?>