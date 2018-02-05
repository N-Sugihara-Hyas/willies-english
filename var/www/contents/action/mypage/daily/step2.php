<?php
/*
*	ピンポイントのレッスン予約1
*/

		//モデル情報の読み込み
		$this->addModel(array('member/Base', 'member/Reserve', 'cource/Style', 'take/Base', 'take/Schedule', 'take/Reserve'));
		$this->addLiblary(array('inoutput/Date'));

		$this->getCommon();
		if ($this->arrayUser['dateTestDaily']){$this->setRedirect('errors');}

		if (isset($this->arrayPost['cource_base_daily_id'])){			
			$this->MemberBase->setSession('cource', $this->arrayPost);
			$arrayCource = $this->arrayPost;
		}else{
			$arrayCource = $this->MemberBase->getSession('cource');
		}		
		
		$cID = $arrayCource['cource_base_daily_id'];		

		if (isset($this->arrayAll['time']) ){
			$arrayDate[0]['time'] = $this->arrayAll['time'];
			$arrayDate[0]['date'] = $this->arrayAll['date'];
			$arrayDate[0]['tID'] = $this->arrayAll['tID'];
			$this->MemberBase->setSession('schedule', $arrayDate);
			
			$this->set('next', 1);
		}
		if (isset($this->arrayAll['next'])){
			$this->set('next', 1);
		}


		//スケジュールの条件を取得
		$time = time();

		if (isset($this->arrayAll['dateNow'])){
			$date = $this->arrayAll['dateNow'];
		}else{
			$date = date('Y-m-d', $time);
		}

		//対応コースの講師の取得
		$this->TakeBase->mode = 1;
		$arrayTake = $this->TakeBase->getDataCource($cID);

		$this->set('arrayTake', $arrayTake);
		$this->set('arrayTime', $this->TakeSchedule->getArrayTime(25) );
		
		$this->TakeReserve->mode = 1;
		$this->set('arrayCourceSchedule', $this->TakeReserve->getDataDate($cID, $date, 25));
		$this->set('date', $date);

		$this->set('dateNext', date('Y-m-d', strtotime($date) + (3600 * 24)));
		$this->set('dateBack', date('Y-m-d', strtotime($date) - (3600 * 24)));
		$this->set('tID', getVar($this->arrayAll, 'tID'));
		$this->set('title', 'グループ音読レッスン 登録');


?>