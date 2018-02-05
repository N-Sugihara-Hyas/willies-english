<?php
/*
*	ピンポイントのレッスン予約3
*/

		//モデル情報の読み込み
		$this->addModel(array('member/Daily', 'cource/Base', 'member/Reserve', 'cource/Style', 'member/Setting', 'member/Base', 'take/Base', 'take/Schedule', 'take/Reserve', 'master/AdminNews', 'member/Cancel'));

		$this->getCommon();

		//指定した情報の保存とチェック
		if (!$arrayData2 = $this->MemberSetting->getSettingStep2(2, $this->arrayAll)){
			$this->setRedirect('mypage/setting/step2_1/?error=1');
		}

		$this->TakeReserve->isB = true;

		if (!$this->uid){
			$cID =$this->arrayUser['cource_base_id'];
			$csID =$this->arrayUser['cource_style_id'];

			$arrayCourceStyle = $this->CourceStyle->getDataUID($csID)->getData();

			//その予約が可能かの判定
			if (!$title = $this->MemberReserve->isReserveType($this->arrayUser, getVar($this->arrayAll, 'type'), $arrayCourceStyle)){
				$this->setRedirect('errors');
			}


			$arrayDate = $this->MemberBase->getSession('schedule');
			//音読の場合
			if ($this->arrayAll['type'] == 3){
				$this->TakeReserve->mode = 1;

				$skypeTime = 25;

				$arrayCource = $this->MemberBase->getSession('cource');
				$cID = $arrayCource['cource_base_daily_id'];
			}else{
				$cID = $this->arrayUser['cource_base_id'];
			}

			$csID = $this->arrayUser['cource_style_id'];
			$skypeTime = $arrayCourceStyle['weekTime'];

			$arrayCourceStyle = $this->CourceStyle->getDataUID($csID)->getData();

			//そのスケジュールで、その講師が確保ができるか再チェック
			$this->TakeReserve->isScheduleLimit = true;
			if (!$this->TakeReserve->getDataTime($cID, $arrayData2['date'], $arrayData2['time'], $skypeTime,$this->arrayAll['type'],  $arrayData2['tID'])){
				$this->setRedirect('mypage/return/step1?error=1&type=' . $this->arrayAll['type']);
			}

			$triout = 0;


			if ($this->arrayAll['type'] == 1){
				//メール送付
				$arrayDataResult = $arrayData2;
				$arrayDataResult['cID']  = $cID;
				$arrayDataResult['csID']  = $csID;
				$arrayDataResult['cshID']  = '';

				$arrayDate['date'] = $arrayData2['date'];
				$arrayDate['time'] = $arrayData2['time'];
				$arrayTakeBase = $this->TakeBase->getDataUID($arrayData2['tID'])->getData();
				$arrayDate['takeName'] = $arrayTakeBase['nickname'];

				$this->MasterAdminNews->sendMail($this->arrayUser, $arrayDataResult, $arrayCourceStyle, $this->arraySetting, $arrayDate, 30, 28);

				//通常レッスンの予約
				$this->TakeReserve->mode = 2;

				if ((!$this->arrayUser['isPay']) && ($this->arrayUser['state'] != 10) && ($this->arrayUser['state'] != 11)){
					//支払いしてない人間は体験学習に
					$triout = 1;
					$this->arrayUser['dateTest'] = $arrayData2['date'];
				}


				$this->arrayUser['countLesson']--;
				$this->MemberBase->commit($this->arrayUser);
			}

			//グループレッスンの予約
			if ($this->arrayAll['type'] == 3){
				if (!$this->arrayUser['isPayDaily']){
					$triout = 1;
					$this->arrayUser['dateTestDaily'] = $arrayData2['date'];
				}

				$this->arrayUser['countDaily']--;

				$this->MemberBase->commit($this->arrayUser);

				//グループの体験の場合は、ステータスを体験に変更
				$this->arrayUser['stateDaily'] = 1;
				$this->arrayUser = $this->MemberBase->setStatusDaily($this->arrayUser);
			}

			//振替の場合は振替ポイントの減少
			if ($this->arrayAll['type'] == 2){
				$this->MasterAdminNews->sendMailReturn($this->arrayUser, $arrayData2);

				//体験キャンセルの際はカウントを減らさない代わりに、セッションを削除する
				/*if ($this->MemberCancel->getSession('traialCancel') ){
					$this->MemberCancel->setSession('traialCancel', '');
					$triout = 1;
				}else{*/
					$this->arrayUser['countReturn']--;
					$this->MemberBase->commit($this->arrayUser);
				//}

			}


			//スケジュール確保
			$this->TakeReserve->addDataTime($this->arrayUser['id'], $arrayData2['date'], $arrayData2['time'], $arrayCourceStyle['weekTime'],$csID, $arrayData2['tID'], $this->arrayAll['type'], $triout);



			//グループ音読レッスンの場合はグループの確保
			if ($this->arrayAll['type'] == 3){
				$this->MemberDaily->setReserver($arrayData2['tID'], $arrayData2['date'], $arrayData2['time']);
			}

			//レッスン予約の履歴の作成(ほぼ不要になったが一応作成)
			$this->addLiblary('inoutput/Date');
			$w = InoutputDate::getWeekCount(date('Y-m-d'));

			$arrayDataReserve['member_base_id'] = $this->arrayUser['id'];
			$arrayDataReserve['type'] = $this->arrayAll['type'];
			$arrayDataReserve['date'] = date('Ym' . $w);
			$this->MemberReserve->commit($arrayDataReserve);

			$this->set('title', $title);


			$this->setRedirect('mypage/return/end/reflash/');
		}

?>