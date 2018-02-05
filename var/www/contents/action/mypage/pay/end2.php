<?php
/*
*	支払い完了
*/

	//モデル情報の読み込み
	$this->addModel(array('member/Base', 'master/AdminNews', 'member/Setting'));
	$this->addLiblary(array('tool/Paypal'));

	$this->getCommon();

	//何分制かの取得
	$arrayCource = $this->CourceStyle->getDataUID($this->arrayUser['cource_style_id'])->getData();
	$type = $this->MemberBase->getSession('type');


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


	if (!$this->uid){
		$paymentAmount = $money;
		$description = $typeName;//項目名

		$startdate =  date( "Y-m-d",time())."T0:0:0";

		$Paypal = new Paypal('company_api1.williesenglish.com', 'GGRWEV4GDSQDD6AF', 'AFcWxV21C7fd0v3bYYYRCpSSRl31A-GB0mxAuBdIvGs-6H9xLMOFYpe7');
		
		
		$res = $Paypal->ConfirmPayment($paymentAmount,$_SESSION["PayPalShippingDetail"]);
		
		
		if( $res["ACK"] == "SUCCESS" || $res["ACK"] == "SUCCESSWITHWARNING" || $res["ACK"] == 'Success' ){			
			
		}else{
			echo "Fail";
			exit();
		}
		
		//支払処理
		if ($arrayCource['weekTake']){
			$this->arrayUser['countReturn']+=5;
		}else{
			$this->arrayUser['countLesson']+=5;
		}

		$this->MemberBase->commit($this->arrayUser);
		
		$this->set('arrayUser', $this->arrayUser);
		$this->setRedirect('mypage/pay/end2/reflash/');
	}

	$this->set('arrayUser', $this->arrayUser);
?>