<?php
/*
*	初期設定画面2
*/

		//モデル情報の読み込み
		$this->addModel(array('master/AdminNews', 'cource/Base', 'cource/Style', 'member/Base', 'member/Setting', 'setting/Meta', 'take/Base', 'take/Schedule', 'take/Reserve', 'master/AdminNews'));

		$this->getCommon();

		if (!$arrayData = $this->MemberSetting->getSettingStep(6, $this->arrayAll) ){
			$this->setRedirect('setting/step5/?error=1');
		}


		if (!$this->uid){
			//全てのセッションの取得
			$arrayMember = $this->MemberBase->getDataUID($this->MemberSetting->getSession('mid'))->getData();

			$arrayMember['cource_base_id'] = $arrayData['cID'];
			$arrayMember['cource_style_id'] = $arrayData['csID'];
			$arrayMember['cource_schedule_id'] = $arrayData['cshID'];



			$arrayMember['time'] = $arrayData['time'];
			$arrayMember['take_base_id'] = $arrayData['tID'];


			//全ての受講曜日の取得
			$arrayDate = $this->TakeSchedule->getWeekData($arrayData['dateFirst'], $arrayData['cshID'], $arrayData['cID']);

			$arrayMember['dateTest'] = $arrayDate[1];

			//受講プランの選択肢の取得
			$arrayCourceStyle = $this->CourceStyle->getDataUID($arrayData['csID'])->getData();

			$arrayMember['weekTime'] = $arrayCourceStyle['weekTime'];


			$trial = true;


			//そのスケジュールで、その講師が確保ができるか再チェック
			if (!$this->TakeReserve->getDataTime($arrayData['cID'], $arrayDate[0], $arrayData['time'], $arrayCourceStyle['weekTime'],1, $arrayMember['take_base_id'])){
				$this->setRedirect('setting/step4?error=1');
			}


			
			//現在の体験数の取得(２つ未満の場合は体験を削除するため)
			$this->TakeReserve->addQuery('isTrial', 1);
			$this->TakeReserve->addQuery('member_base_id', $arrayMember['id']);
			$this->TakeReserve->addQuery('concat(date," ",timeStart) >=', date('Y-m-d H:i:s'));

			$countTake = 2 - $this->TakeReserve->getData()->getCount();
			
			//予備として、スケジュールの消去
			$this->TakeReserve->addQuery('member_base_id', $arrayMember['id']);
			$this->TakeReserve->addQuery('type <=', 1);
			$this->TakeReserve->addQuery('concat(date," ",timeStart) >=', date('Y-m-d H:i:s'));
			$this->TakeReserve->delData();

			//通常レギュラーコースの予約
			$this->TakeReserve->addDataWeek($arrayDate[0], $arrayMember['id'], $arrayData['cID'], $arrayData['cshID'], $arrayData['time'], $arrayCourceStyle['weekTime'], $arrayMember['take_base_id'], 1, $trial, $arrayData['csID']);

			$this->TakeReserve->addQuery('isTrial', 1);
			$this->TakeReserve->addQuery('type <=', 1);
			$this->TakeReserve->addQuery('concat(date," ",timeStart) >=', date('Y-m-d H:i:s'));
			$this->TakeReserve->order = 'date DESC';
			$arrayReserve = $this->TakeReserve->getData()->getDataAll();



			for ($i = 0; $i < $countTake; $i++){
				$this->TakeReserve->addQuery('id', $arrayReserve[$i]['id']);
				$this->TakeReserve->setData(array('isTrial'=> 0));
			}

			//ユーザーの情報の更新
			$this->MemberBase->setDataSetting($arrayMember['id'], $arrayMember);

			$this->MemberSetting->clear();

			$this->setRedirect('customer/list/?e=reflash');
	}
?>