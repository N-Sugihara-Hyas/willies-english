<?php
require_once ("paypalfunctions.php");
$paymentAmount = 1;//金額
$payment2 = 1000;//初回課金　入会金など

$payment_Message = "１ヶ月１円定期購読\n初回入会金　1000円 ";//項目名
$returnURL = "http://stest.package-test.info/paypal/review.php";//戻り先
$cancelURL = "http://stest.package-test.info/paypal/index.php";//キャンセル次の戻り先
$res = CallRecurringPayments ($paymentAmount, $payment_Message ,$returnURL, $cancelURL,$payment2,"初回課金1000円\n月額課金100円");
if($res){
	RedirectToPayPal ($res );
}else{
	echo "Fail.";
}