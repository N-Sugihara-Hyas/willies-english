<?php
/*
*	paypalへのつなぎ込み
*/

	//モデル情報の読み込み
	$this->addModel(array('cource/Style'));
	$this->addLiblary(array('tool/Paypal'));

	$this->getCommon();

	if (isset($_REQUEST['token'])){
		$token = $_REQUEST['token'];
	}else{
		echo "Fail";
		exit();
	}


	$type = $this->MemberBase->getSession('type');

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
	

	$this->set('res', $res);
	$this->set('typeName', $typeName);
	$this->set('arrayCource', $arrayCource);
?>
