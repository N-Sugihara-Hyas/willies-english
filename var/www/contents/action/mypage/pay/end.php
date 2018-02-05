<?php
/*
*	支払い完了
*/

	//モデル情報の読み込み
	$this->addModel(array('cource/Style', 'take/Schedule', 'cource/Base', 'member/Base', 'master/AdminNews', 'member/Setting'));
	$this->addLiblary(array('tool/Paypal'));

	$this->getCommon();
	

	if (!$this->uid){
		if ($this->MemberSetting->getSession('trialout') ){
			$this->addModel(array('take/Reserve'));

			$arrayData = $this->MemberSetting->getSettingStep(2, array());
			$this->arrayUser['cource_base_id'] = $arrayData['cID'];
			$this->arrayUser['cource_style_id'] = $arrayData['csID'];

			$this->MemberSetting->arrayUser = $this->arrayUser;

			if ($this->MemberSetting->getSession('trialout') == 'mypage/setting/end2/'){$countCheck = 2;}else{$countCheck = 6;}

			if (!$arrayData = $this->MemberSetting->getSettingStep($countCheck, $this->arrayAll) ){
				if ($countCheck == 2){
					$this->setRedirect('mypage/setting/step2_1/?error=1');
				}else{
					$this->setRedirect('mypage/setting/step5/?error=1');
				}
			}

			$arrayCource = $this->CourceStyle->getDataUID($this->arrayUser['cource_style_id'])->getData();
			$type = $this->MemberBase->getSession('type');

			//全ての受講曜日の取得
			if ($countCheck == 2){
				//if (!$arrayData2 = $this->MemberSetting->getSettingStep2(1, $this->arrayAll)){
				//	$this->setRedirect('mypage/setting/step2_1/?error=1');
				//}

				//$arrayDate = $this->MemberBase->getSession('schedule');
			}else{
				$arrayDate = $this->TakeSchedule->getWeekData($arrayData['dateFirst'], $arrayData['cshID'], $arrayData['cID']);
			}


			$arrayCourceStyle = $this->CourceStyle->getDataUID($arrayData['csID'])->getData();

			//そのスケジュールで、その講師が確保ができるか再チェック
			if ($countCheck == 2){
				/*if (!$this->TakeReserve->getDataTime($arrayData['cID'], $arrayData2['date'], $arrayData2['time'], $arrayCourceStyle['weekTime'], 1)){
					$this->setRedirect('mypage/setting/step2_1/?error=1');
				}*/
			}else{
				if (!$this->TakeReserve->getDataTime($arrayData['cID'], $arrayDate[0], $arrayData['time'], $arrayCourceStyle['weekTime'],1, $arrayData['tID'])){
					$this->setRedirect('mypage/setting/step4?error=1');
				}
			}
		}else{
			$arrayCource = $this->CourceStyle->getDataUID($this->arrayUser['cource_style_id'])->getData();
			$type = $this->MemberBase->getSession('type');
		}


		
		if ($type == 2){
			$money = $arrayCource['groupMoney'];
			$typeName = 'グループ音読レッスン(' . $money . '円)';
		}else{
			$money = $arrayCource['weekMoney'];
			$typeName = $arrayCource['courceStyleName'] . '|' . 'レギュラーレッスン';
		}

		$paymentAmount = $money;
		$description = $typeName;//項目名

		$startdate =  date( "Y-m-d",time())."T0:0:0";

		if ($_SERVER['REMOTE_ADDR'] != '124.41.94.252'){
			$Paypal = new Paypal('company_api1.williesenglish.com', 'GGRWEV4GDSQDD6AF', 'AFcWxV21C7fd0v3bYYYRCpSSRl31A-GB0mxAuBdIvGs-6H9xLMOFYpe7');
			$res = $Paypal->CreateRecurringPaymentsProfile($paymentAmount,$description,$startdate,$_SESSION["PayPalShippingDetail"] );
			
			
			if( $res["ACK"] == "SUCCESS" || $res["ACK"] == "SUCCESSWITHWARNING" || $res["ACK"] == 'Success' ){
				$this->arrayUser['orderID' . $type] = $res["PROFILEID"];
				$this->arrayUser['dateUnRegist'] = '';
				
				
				
				if (!$arrayCource['weekTake']){
					$this->arrayUser['countLesson']+=$arrayCource['weekCount'];
				}
				
				$this->MemberBase->commit($this->arrayUser);
				
			}else{
				echo "Fail";
				exit();
			}
	
			//メールの送信
			$this->MasterAdminNews->sendMailPay($type, $this->arrayUser, $arrayCourceStyle);
		}
		
		//支払処理
		$this->MemberBase->setPay($this->arrayUser['id'], $type);
		

		$trialout = $this->MemberSetting->getSession('trialout');

		if (strlen($trialout) >= 5){
			if ($trialout == 'mypage/setting/end2/'){
				$this->setRedirect('mypage/pay/end/reflash/?type=' . $type);
			}else{
				$this->setRedirect($trialout);
			}
		}else{
			$this->setRedirect('mypage/pay/end/reflash/?type=' . $type);
		}
	}else{
			$type = $this->MemberBase->getSession('type');
	}
	
	$this->set('type', $type);

?>