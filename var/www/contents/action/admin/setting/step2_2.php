<?php
/*
*	初期設定画面2
*/

		//モデル情報の読み込み
		$this->addModel(array('cource/Style', 'member/Setting', 'setting/Meta', 'take/Schedule', 'take/Reserve'));
		$this->addLiblary(array('inoutput/Date'));

		$this->getCommon('first');


		if (!$arrayData = $this->MemberSetting->getSettingStep(2, $this->arrayAll)){
			$this->setRedirect('mypage/setting/step2_1/?error=1');
		}		
		
		if (!$arrayData2 = $this->MemberSetting->getSettingStep2(1, $this->arrayAll)){
			$this->setRedirect('mypage/setting/step2_1/?error=1');
		}

		

		//受講プランの選択肢の取得
		$arrayCourceStyle = $this->CourceStyle->getDataUID($arrayData['csID'])->getData();
		
		$this->TakeReserve->joinTakeBase();
		$this->TakeReserve->mode = 2;
		$arrayCourceSchedule = $this->TakeReserve->getDataTime($arrayData['cID'], $arrayData2['date'], $arrayData2['time'], $arrayCourceStyle['weekTime'], 1);
		

		$this->set('arrayCourceStyle', $arrayCourceStyle);
		$this->set('date', $arrayData2['date']);		
		$this->set('time', $arrayData2['time']);
		$this->set('arrayCourceSchedule', $arrayCourceSchedule);

		$this->set('arrayWeek', array('日', '月', '火', '水', '木', '金', '土'));

?>