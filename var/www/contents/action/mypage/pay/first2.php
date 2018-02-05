<?php
/*
*	paypalへのつなぎ込み
*/

	//モデル情報の読み込み
	$this->addModel(array('cource/Style'));
	$this->addLiblary(array('tool/Paypal'));

	$this->getCommon();
	
	//何分制かの取得
	$arrayCource = $this->CourceStyle->getDataUID($this->arrayUser['cource_style_id'])->getData();

	if ($arrayCource['weekTime'] == 50){
		$money = 3750;
		$typeName = '50分レッスン、５ポイント購入（3,750円 税別）';
		$type = '50';
	}else{
		$money = 2250;
		$typeName = '25分レッスン、５ポイント購入（2,250円 税別）';
		$type = '25';
	}
	$money = $money + ($this->arraySetting['tax'] * $money);

	$this->MemberBase->setSession('typeSingle', $type);
	
	$paymentAmount = $money;
	$payment_Message = $typeName;//項目名
		
	$returnURL = "http://" . $this->arraySetting['domain'] . "/mypage/pay/review2/";//戻り先
	$cancelURL = "http://" . $this->arraySetting['domain'] . "/mypage/";//キャンセル次の戻り先
	
	
	$Paypal = new Paypal('company_api1.williesenglish.com', 'GGRWEV4GDSQDD6AF', 'AFcWxV21C7fd0v3bYYYRCpSSRl31A-GB0mxAuBdIvGs-6H9xLMOFYpe7');
	
	$res = $Paypal->CallShortcutExpressCheckout ($paymentAmount ,$returnURL, $cancelURL, $typeName);
		
	if($res){
		$Paypal->RedirectToPayPal ($res );
	}else{
		echo "Fail.";
	}

?>