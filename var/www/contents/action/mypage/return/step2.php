<?php
/*
*	ピンポイントのレッスン予約2
*/
		//モデル情報の読み込み
		$this->addModel(array('cource/Base', 'member/Reserve', 'cource/Style', 'member/Setting', 'take/Base', 'take/Reserve'));

		$this->getCommon();

		//指定した情報の保存とチェック
		if (!$arrayData2 = $this->MemberSetting->getSettingStep2(1, $this->arrayAll)){
			$this->setRedirect('mypage/setting/step2_1/?error=1');
		}

		if ($this->arrayAll['type'] == 3){
			$this->TakeReserve->mode = 1;
			$arrayCource = $this->MemberBase->getSession('cource');

			$cID = $arrayCource['cource_base_daily_id'];			
		}else{
			$this->TakeReserve->mode = 2;
			$cID =$this->arrayUser['cource_base_id'];
		}

		$csID =$this->arrayUser['cource_style_id'];

		$arrayCourceStyle = $this->CourceStyle->getDataUID($csID)->getData();

		//その予約が可能かの判定
		if (!$title = $this->MemberReserve->isReserveType($this->arrayUser, getVar($this->arrayAll, 'type'), $arrayCourceStyle)){
			$this->setRedirect('errors');
		}
		

		$this->TakeReserve->joinTakeBase();
		
		$this->TakeReserve->isB = true;
		$this->TakeReserve->isScheduleLimit = true;
		$arrayCourceSchedule = $this->TakeReserve->getDataTime($cID, $arrayData2['date'], $arrayData2['time'], $arrayCourceStyle['weekTime'], $this->arrayAll['type']);
		
		if (!empty($this->arrayAll['tID'])){
			$this->setRedirect('mypage/return/step3/?op=1&tID=' . $this->arrayAll['tID'] . '&type=' . $this->arrayAll['type']);
		}

		$this->set('date', $arrayData2['date']);
		$this->set('time', $arrayData2['time']);
		$this->set('arrayCourceSchedule', $arrayCourceSchedule);
		$this->set('title', $title);
		$this->set('type', $this->arrayAll['type']);

		

?>