<?php
/*
*	ピンポイントのレッスン予約3
*/

		//モデル情報の読み込み
		$this->addModel(array('cource/Base', 'member/Reserve', 'cource/Style', 'member/Base', 'take/Base', 'take/Schedule', 'take/Reserve', 'member/Daily'));

		$this->getCommon();

		if (!$this->uid){
			
			if ($this->arrayUser['dateTestDaily']){$this->setRedirect('errors');}

			$arrayDate = $this->MemberBase->getSession('schedule');

			$arrayCource = $this->MemberBase->getSession('cource');
			$arrayDataUser['cource_base_daily_id'] = $cID = $arrayCource['cource_base_daily_id'];
			//$arrayDataUser['levelDaily'] = $arrayCource['level'];
			
			if (strtotime($arrayDate[0]['date'] . ' ' . $arrayDate[0]['time']) > strtotime($arrayDate[1]['date'] . ' ' . $arrayDate[1]['time'])){
				$arrayDataUser['dateTestDaily'] = $arrayDate[0]['date'] . ' ' . $arrayDate[0]['time'] . ':00';
			}else{
				$arrayDataUser['dateTestDaily'] = $arrayDate[1]['date'] . ' ' . $arrayDate[1]['time'] . ':00';
			}
			
			$this->MemberBase->setDataSetting($this->arrayUser['id'], $arrayDataUser);

			//そのスケジュールで、その講師が確保ができるか再チェック
			$this->TakeReserve->mode = 1;
			foreach ($arrayDate as $item){
				if (!$this->TakeReserve->getDataTime($cID, $item['date'], $item['time'], 25, $item['tID'])){
					$this->setRedirect('mypage/daily/step2?error=1');
				}
			}
			
			foreach ($arrayDate as $item){
				//スケジュールの確保
				$this->TakeReserve->addDataTime($this->arrayUser['id'], $item['date'], $item['time'], 25, $item['tID'], 3);
				$this->MemberDaily->setReserver($item['tID'], $item['date'], $item['time']);

			}
			


			$this->set('title', 'グループ音読レッスン 登録');
			$this->setRedirect('mypage/return/end/reflash/');
		}

?>