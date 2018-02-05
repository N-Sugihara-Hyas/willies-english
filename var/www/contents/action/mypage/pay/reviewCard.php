<?php
/*
*	paypalへのつなぎ込み
*/


	//モデル情報の読み込み
	$this->addModel(array('cource/Style', 'take/Schedule', 'cource/Base', 'member/Setting'));
	$this->addLiblary(array('tool/Paypal'));


	$this->getCommon();

	$money = 500;

	if (isset($_REQUEST['token'])){
		$token = $_REQUEST['token'];
	}else{
		echo "Fail";
		exit();
	}

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
?>
