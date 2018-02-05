<?php
/*
*	初期設定画面2
*/

		//モデル情報の読み込み
		$this->addModel(array('master/AdminNews', 'cource/Base', 'cource/Style', 'member/Base', 'member/Setting', 'setting/Meta', 'take/Base', 'take/Schedule', 'take/Reserve', 'master/AdminNews'));

		$this->getCommon('first');

		if (!$arrayData = $this->MemberSetting->getSettingStep(6, $this->arrayAll) ){
			$this->setRedirect('mypage/setting/step5/?error=1');
		}


		if (!$this->uid){
			//全てのセッションの取得
			$arrayMember = $this->arrayUser;
			$arrayMember['cource_base_id'] = $arrayData['cID'];
			$arrayMember['cource_style_id'] = $arrayData['csID'];
			$arrayMember['cource_schedule_id'] = $arrayData['cshID'];


			$arrayMember['time'] = $arrayData['time'];
			$arrayMember['take_base_id'] = $arrayData['tID'];

			if ($arrayMember['cource_base_id'] == 1){
				$arrayMember['level'] = intval(getVar($arrayData, 'levelChild'));
			}

			$arrayData['isSetting'] = 1;

			//全ての受講曜日の取得
			$arrayDate = $this->TakeSchedule->getWeekData($arrayData['dateFirst'], $arrayData['cshID'], $arrayData['cID']);

			if (!$this->arrayUser['isSetting']){
				$arrayMember['dateTest'] = $arrayDate[1];
				$arrayMember['state'] = 1;
			}




			//受講プランの選択肢の取得
			$arrayCourceStyle = $this->CourceStyle->getDataUID($arrayData['csID'])->getData();

			$arrayMember['weekTime'] = $arrayCourceStyle['weekTime'];


			$trial = true;
			if ($this->arrayUser['isSetting']){
				//月に一度だけ変更可能に
				if (!$this->MemberBase->isChange($this->arrayUser)){$this->setRedirect('erros');}

				//変更の場合
				$trial = false;
				$arrayMember['dateChange'] = date('Ym');
			}


			//そのスケジュールで、その講師が確保ができるか再チェック
			if (!$this->TakeReserve->getDataTime($arrayData['cID'], $arrayDate[0], $arrayData['time'], $arrayCourceStyle['weekTime'],1, $arrayMember['take_base_id'])){
				$this->setRedirect('mypage/setting/step4?error=1');
			}



			if (!$this->arrayUser['isSetting']){
				if ($arrayData['csID'] == 4){
					$this->MasterAdminNews->sendMail($this->arrayUser, $arrayData, $arrayCourceStyle, $this->arraySetting, $arrayDate, 29);
				}else{
					$this->MasterAdminNews->sendMail($this->arrayUser, $arrayData, $arrayCourceStyle, $this->arraySetting, $arrayDate);
				}
			}else{
				//変更の際の前講師にメッセージの送付
				$this->MasterAdminNews->addModelTool('Mail');
				$arrayTakeBack = $this->TakeBase->getDataUID($this->arrayUser['take_base_id'])->getData();

				if ($arrayData['csID'] == 4){
					$this->MasterAdminNews->sendMail($this->arrayUser, $arrayData, $arrayCourceStyle, $this->arraySetting, $arrayDate, 29, 15, $arrayTakeBack);
				}else{
					$this->MasterAdminNews->sendMail($this->arrayUser, $arrayData, $arrayCourceStyle, $this->arraySetting, $arrayDate, 14, 15, $arrayTakeBack);
				}
			}



			//予備として、体験スケジュールの消去
			$this->TakeReserve->addQuery('member_base_id', $this->arrayUser['id']);
			$this->TakeReserve->addQuery('type <=', 1);
			$this->TakeReserve->addQuery('concat(date," ",timeStart) >=', date('Y-m-d H:i:s'));
			$this->TakeReserve->delData();

			//通常レギュラーコースの予約
			$this->TakeReserve->addDataWeek($arrayDate[0], $this->arrayUser['id'], $arrayData['cID'], $arrayData['cshID'], $arrayData['time'], $arrayCourceStyle['weekTime'], $arrayMember['take_base_id'], 1, $trial, $arrayData['csID']);

			//ユーザーの情報の更新
			$this->MemberBase->setDataSetting($this->arrayUser['id'], $arrayMember);

			$this->MemberSetting->clear();

			$this->setRedirect('mypage/setting/end/reflash/');
	}
?>