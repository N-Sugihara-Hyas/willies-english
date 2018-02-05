<?php
/*
*	支払い完了
*/

	//モデル情報の読み込み
	$this->addModel(array('member/Base'));
	$this->addLiblary(array('tool/Paypal'));

	$this->getCommon();
	


	if (!$this->uid){
		$paymentAmount = 500;
		$description = '単語帳プラン(' . $paymentAmount . '円)';

		$startdate =  date( "Y-m-d",time())."T0:0:0";

		$Paypal = new Paypal('company_api1.williesenglish.com', 'GGRWEV4GDSQDD6AF', 'AFcWxV21C7fd0v3bYYYRCpSSRl31A-GB0mxAuBdIvGs-6H9xLMOFYpe7');
		$res = $Paypal->CreateRecurringPaymentsProfile($paymentAmount,$description,$startdate,$_SESSION["PayPalShippingDetail"] );
		
		if( $res["ACK"] == "SUCCESS" || $res["ACK"] == "SUCCESSWITHWARNING" || $res["ACK"] == 'Success' ){
			$this->arrayUser['orderIDCard'] = $res["PROFILEID"];
			$this->arrayUser['isPayCard'] = 1;
						
			$this->MemberBase->commit($this->arrayUser);
			
		}else{
			echo "Fail";
			exit();
		}

		$this->setRedirect('mypage/pay/endCard/reflash/');
	}
?>