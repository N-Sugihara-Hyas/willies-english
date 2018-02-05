<?php
/*
*	paypalへのつなぎ込み
*/

	//モデル情報の読み込み
	$this->addLiblary(array('tool/Paypal'));

	$this->getCommon();
	

	$money = 500;
	$typeName = '単語帳プラン(' . $money . '円)';
		
	$paymentAmount = $money;
	$payment_Message = $typeName;//項目名
		
	$returnURL = "http://" . $this->arraySetting['domain'] . "/mypage/pay/reviewCard/";//戻り先
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