<?php
/*
*	paypalへのつなぎ込み
*/

	//モデル情報の読み込み
	$this->addModel(array('cource/Style', 'member/Setting'));
	$this->addLiblary(array('tool/Paypal'));

	$this->getCommon();
	
	$type = $this->arrayAll['type'];


	if ($this->MemberSetting->getSession('trialout') ){
		$arrayData = $this->MemberSetting->getSettingStep(2, array());
		$this->arrayUser['cource_style_id'] = $arrayData['csID'];
	}

	$arrayCource = $this->CourceStyle->getDataUID($this->arrayUser['cource_style_id'])->getData();

	if ($type == 2){
		$money = $arrayCource['groupMoney'];
		$typeName = 'グループ音読レッスン(' . $money . '円)';
	}else{
		$money = $arrayCource['weekMoney'];
		$typeName = $arrayCource['courceStyleName'] . '|' . 'レギュラーレッスン';
	}
	
	$this->MemberBase->setSession('type', $type);
	
	$paymentAmount = $money;
	$payment_Message = $typeName;//項目名
		
	$returnURL = "http://" . $this->arraySetting['domain'] . "/mypage/pay/review/";//戻り先
	$cancelURL = "http://" . $this->arraySetting['domain'] . "/mypage/";//キャンセル次の戻り先
	
	
	$Paypal = new Paypal('company_api1.williesenglish.com', 'GGRWEV4GDSQDD6AF', 'AFcWxV21C7fd0v3bYYYRCpSSRl31A-GB0mxAuBdIvGs-6H9xLMOFYpe7');
	
	$res = $Paypal->CallRecurringPayments ($paymentAmount, $payment_Message ,$returnURL, $cancelURL);
		
	if($res){
		$Paypal->RedirectToPayPal ($res );
	}else{
		echo "Fail.";
	}
	exit();


?>