<?php
/*
*	paypalへのつなぎ込み
*/


	//モデル情報の読み込み
	$this->addModel(array('cource/Style', 'take/Schedule', 'cource/Base', 'member/Setting'));
	$this->addLiblary(array('tool/Paypal'));


	$this->getCommon();


	if ($this->MemberSetting->getSession('trialout') ){
		$this->addModel(array('take/Reserve'));


		
		if ($this->MemberSetting->getSession('trialout') == 'mypage/setting/end2/'){$countCheck = 2;}else{$countCheck = 6;}



		$this->MemberSetting->arrayUser = $this->arrayUser;
		if (!$arrayData = $this->MemberSetting->getSettingStep($countCheck, $this->arrayAll) ){
			if ($countCheck == 2){
				$this->setRedirect('mypage/setting/step2_1/?error=1');
			}else{
				$this->setRedirect('mypage/setting/step5/?error=1');
			}
		}

		
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
			//if (!$this->TakeReserve->getDataTime($arrayData['cID'], $arrayData2['date'], $arrayData2['time'], $arrayCourceStyle['weekTime'], 1)){
				//$this->setRedirect('mypage/setting/step2_1/?error=1');
			//}
			$this->set('isB', true);
		}else{
			if (!$this->TakeReserve->getDataTime($arrayData['cID'], $arrayDate[0], $arrayData['time'], $arrayCourceStyle['weekTime'],1, $arrayData['tID'])){
				$this->setRedirect('mypage/setting/step4?error=1');
			}
		}
	}



	//if ($_SERVER['REMOTE_ADDR'] != '124.41.94.252'){
		if (isset($_REQUEST['token'])){
			$token = $_REQUEST['token'];
		}else{
			echo "Fail";
			exit();
		}
	//}
	

	if (!$arrayData['csID']){$arrayData['csID'] = $this->arrayUser['cource_style_id'];}

	$arrayCource = $this->CourceStyle->getDataUID($arrayData['csID'])->getData();

	$type = $this->MemberBase->getSession('type');
	
	if ($type == 2){
		$money = $arrayCource['groupMoney'];
		$typeName = 'グループ音読レッスン';
	}else{
		$money = $arrayCource['weekMoney'];
		$typeName = 'レギュラーレッスン';
	}

	if ($_SERVER['REMOTE_ADDR'] != '124.41.94.252'){
		$Paypal = new Paypal('company_api1.williesenglish.com', 'GGRWEV4GDSQDD6AF', 'AFcWxV21C7fd0v3bYYYRCpSSRl31A-GB0mxAuBdIvGs-6H9xLMOFYpe7');
		$res = $Paypal->GetShippingDetails( $token );
	
	
		if($res){
			$res["TOKEN"] = $token;
			$_SESSION["PayPalShippingDetail"] = $res;
	
	
			if ($_SESSION["PayPalShippingDetail"]['AMT'] != $money){
				echo "FAIL.";
				exit();			
			}
		}else{
			echo "FAIL.";
			exit();
		}
	}
	

	$this->set('res', $res);
	$this->set('type', $type);
	$this->set('arrayCource', $arrayCource);
?>
