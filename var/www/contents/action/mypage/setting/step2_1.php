<?php
/*
*	初期設定画面2_1
*/

		//モデル情報の読み込み
		$this->addModel(array('cource/Style', 'member/Setting', 'setting/Meta', 'take/Base', 'take/Schedule', 'take/Reserve'));
		$this->addLiblary(array('inoutput/Date'));

		$this->getCommon('first');

		if (!$arrayData = $this->MemberSetting->getSettingStep(2, $this->arrayAll) ){
			$this->setRedirect('mypage/setting/step2/?error=1');
		}

		$arrayDataStyle = $this->CourceStyle->getDataUID($arrayData['csID'])->getData();

		//指定分のスケジュールの取得
		$this->TakeReserve->mode = 2;
		
		$time = time();
		for ($i = 1; $i <= $this->arraySetting['maxReserve']; $i++){
			$arrayDate[$i] = date('Y-m-d', $time + ($i * (3600  *24)));
			$this->TakeReserve->isScheduleLimit = true;


			$arrayCourceSchedule[$arrayDate[$i]] = $this->TakeReserve->getDataDate($arrayData['cID'], $arrayDate[$i], $arrayDataStyle['weekTime'], 1);
		}

		if ($this->arrayUser['isSetting']){
			//ステータスがレギュラー以下の人は再予約は出来ない
			if (($this->arrayUser['state'] < 3) || ($this->arrayUser['state'] == 10) || ($this->arrayUser['state'] == 11)){
				$this->MemberSetting->setSession('trialout', 'mypage/setting/end2/');
				$this->setRedirect('mypage/pay/first/?type=1');
			}
		}

		$this->set('arrayTime', $this->TakeSchedule->getArrayTime($arrayDataStyle['weekTime']) );
		$this->set('arrayCourceSchedule', $arrayCourceSchedule);
		$this->set('arrayDate', $arrayDate);

?>