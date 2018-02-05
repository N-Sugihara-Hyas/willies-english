<?php
/*
*	ピンポイントのレッスン予約1
*/

		//モデル情報の読み込み
		$this->addModel(array('member/Base', 'member/Reserve', 'cource/Style', 'take/Base', 'take/Schedule', 'take/Reserve'));
		$this->addLiblary(array('inoutput/Date'));

		$this->getCommon();

		if ($this->arrayAll['type'] == 3){
			if (isset($this->arrayPost['cource_base_daily_id'])){			
				$this->MemberBase->setSession('cource', $this->arrayPost);
				$arrayCource = $this->arrayPost;
			}else{
				$arrayCource = $this->MemberBase->getSession('cource');
			}		
		
			$cID = $arrayCource['cource_base_daily_id'];
			
			$arrayCourceStyle = array();
			
			$skypeTime = 25;
		}else{
			$skypeTime = 50;
			$cID =$this->arrayUser['cource_base_id'];
		}
		
		$csID = $this->arrayUser['cource_style_id'];
			
		$arrayCourceStyle = $this->CourceStyle->getDataUID($csID)->getData();

		//その予約が可能かの判定
		if (!$title = $this->MemberReserve->isReserveType($this->arrayUser, getVar($this->arrayAll, 'type'), $arrayCourceStyle)){
			$this->setRedirect('errors');
		}
		
		$skypeTime = $arrayCourceStyle['weekTime'];


		//音読の場合
		if ($this->arrayAll['type'] == 3){
			$this->TakeReserve->mode = 1;
			$this->TakeBase->mode = 1;
		}
		//振替えの場合
		if ($this->arrayAll['type'] == 2){
			$this->TakeReserve->mode = 2;
		}
		
		$takeName = getVar($this->arrayAll, 'takeName');

		$this->set('arrayTake', array());

		$tID = 0;
		if ($takeName){
			$this->TakeBase->addQuery('nickname', $takeName);
			$arrayTake = $this->TakeBase->getData()->getData();

			if ($arrayTake['id']){
				$tID = $arrayTake['id'];
			}else{
				$tID  = -100;
			}

			$this->set('arrayTake', $arrayTake);
		}

		$time = time();
		for ($i = 0; $i <= $this->arraySetting['maxReserve']; $i++){
			$arrayDate[$i] = date('Y-m-d', $time + ($i * (3600  *24)));
			
			$this->TakeReserve->isScheduleLimit = true;
			
			$this->TakeReserve->isB = true;
			$arrayCourceSchedule[$arrayDate[$i]] = $this->TakeReserve->getDataDate($cID, $arrayDate[$i], $skypeTime, $this->arrayAll['type'], $tID);
		}

		$this->set('isOK', $this->TakeReserve->isOK);
		$this->set('arrayTime', $this->TakeSchedule->getArrayTime($skypeTime) );
		$this->set('arrayCourceSchedule', $arrayCourceSchedule);
		$this->set('arrayDate', $arrayDate);
		$this->set('type', $this->arrayAll['type']);
		$this->set('takeName', $takeName);
		$this->set('title', $title);
		$this->set('skypeTime', $skypeTime);


?>