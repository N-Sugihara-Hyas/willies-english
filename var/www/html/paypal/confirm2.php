<?php
require_once ("paypalfunctions.php");
$paymentAmount = 100;//金額




$res = ConfirmPayment(1000,$_SESSION["PayPalShippingDetail"]);

if(   $res["ACK"] == "SUCCESS" || $res["ACK"] == "SUCCESSWITHWARNING" || $res["ACK"] == "Success"  ){

		echo "Success<br>";
		echo "TRANSACTIONID:" . $res ["TRANSACTIONID"] . "<br>";
		echo "AMT:" . $res ["AMT"] . "<br>";
		echo "CURRENCYCODE:" . $res ["CURRENCYCODE"] . "<br>";
	}else{
		echo "Fail";
		var_dump($res);
	}
