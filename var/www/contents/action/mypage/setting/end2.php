<?php
/*
*	初期設定画面2
*/

		//モデル情報の読み込み
		$this->addModel(array('cource/Base', 'cource/Style', 'member/Base', 'member/Setting', 'setting/Meta', 'take/Base', 'take/Schedule', 'take/Reserve', 'master/AdminNews'));
		$this->getCommon('first');

		if (!$this->uid){
			if (!$arrayData = $this->MemberSetting->getSettingStep(2, $this->arrayAll)){
				$this->setRedirect('mypage/setting/step2_1/?error=1');
			}		
			if (!$arrayData2 = $this->MemberSetting->getSettingStep2(2, $this->arrayAll)){
				$this->setRedirect('mypage/setting/step2_1/?error=1');
			}

			$arrayDate = $this->MemberBase->getSession('schedule');

			//受講プランの選択肢の取得
			$arrayCourceStyle = $this->CourceStyle->getDataUID($arrayData['csID'])->getData();

			$arrayMember['cource_base_id'] = $arrayData['cID'];
			$arrayMember['cource_style_id'] = $arrayData['csID'];
			$arrayMember['cource_schedule_id'] = '';


			$arrayMember['weekTime'] = $arrayCourceStyle['weekTime'];

			if ($this->arrayUser['isSetting']){
				//ステータスがレギュラー以下の人は再予約は出来ない
				if (($this->arrayUser['state'] < 3) || ($this->arrayUser['state'] == 10) || ($this->arrayUser['state'] == 11)){
					$this->MemberSetting->setSession('trialout', 'mypage/setting/end2/');
					$this->setRedirect('mypage/pay/first/?type=1');
				}else{
					if (!$this->MemberSetting->getSession('trialout')){
						//変更の場合
						if (!$this->MemberBase->isChange($this->arrayUser)){$this->setRedirect('erros');}

						$arrayMember['dateChange'] = date('Ym');
					}
				}
			}else{
				//新規の場合
				$arrayDataResult = array_merge($arrayData, $arrayData2);
				$arrayDate[0] = $arrayData2['date'] . ' '. $arrayData2['time'];
				$arrayMember['countLesson'] = 1;
				
				if (!$this->arrayUser['isSetting']){
					//全ての受講曜日の取得(順番の改修が必要)
					$arrayMember['dateTest'] = $arrayData2['date'];
					$arrayMember['state'] = 1;
				}

				$this->MasterAdminNews->sendMail($this->arrayUser, $arrayDataResult, $arrayCourceStyle, $this->arraySetting, $arrayDate, 24, 43);
			}

			//ユーザーの情報の更新
			$this->MemberBase->setDataSetting($this->arrayUser['id'], $arrayMember);
						
			/*if (!$this->TakeReserve->getDataTime($arrayData['cID'], $arrayData2['date'], $arrayData2['time'], $arrayCourceStyle['weekTime'], 1)){
				$this->setRedirect('mypage/setting/step2_1?error=1');
			}*/

			if (!$this->TakeReserve->getDataTime($arrayData['cID'], $arrayData2['date'], $arrayData2['time'], $arrayCourceStyle['weekTime'], 1)){
				$this->setRedirect('mypage/setting/step2_1/?error=1');
			}

			//スケジュールの確保(変更の場合は行わない)
			if (!$this->arrayUser['isSetting']){
				$this->TakeReserve->addQuery('member_base_id', $this->arrayUser['id']);
				$this->TakeReserve->delData();
				$this->TakeReserve->addDataTime($this->arrayUser['id'], $arrayData2['date'], $arrayData2['time'], $arrayCourceStyle['weekTime'], $arrayMember['cource_style_id'], $arrayData2['tID'], 1, true);
			}else{
				$this->TakeReserve->addDataTime($this->arrayUser['id'], $arrayData2['date'], $arrayData2['time'], $arrayCourceStyle['weekTime'], $arrayMember['cource_style_id'], $arrayData2['tID'], 1, false);
			}


			$this->setRedirect('mypage/setting/end2/reflash/');
		}


		$this->setShow('end');

?>