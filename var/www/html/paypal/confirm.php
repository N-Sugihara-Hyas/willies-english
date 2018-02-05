<?php
require_once ("paypalfunctions.php");

$paymentAmount="1";
$description ="１ヶ月１円定期購読";
$startdate =  date( "Y-m-d",time())."T0:0:0";
echo "startdate:".$startdate."<br>";


$res = ConfirmPayment(1000,$_SESSION["PayPalShippingDetail"]);

	if(   $res["ACK"] == "SUCCESS" || $res["ACK"] == "SUCCESSWITHWARNING" || $res["ACK"] == "Success"  ){

$res = CreateRecurringPaymentsProfile($paymentAmount,$description,$startdate,$_SESSION["PayPalShippingDetail"] );
	if( $res["ACK"] == "SUCCESS" || $res["ACK"] == "SUCCESSWITHWARNING" || $res["ACK"] == "Success" ){
		$PROFILEID =  $res["PROFILEID"];//これをキーに止めたり再開したり確認できるのでちゃんと保存すること。
		echo "Success";
	}else{
		echo "Fail";
		var_dump($res);
	}
		}else{
		echo "Fail";
		var_dump($res);
	}
	echo "PROFILEID:[".$PROFILEID."]<br>";
