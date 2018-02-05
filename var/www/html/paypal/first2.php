<?php
require_once ("paypalfunctions.php");
$paymentAmount = 100;//金額

$returnURL = "http://stest.package-test.info/paypal/review2.php";//戻り先
$cancelURL = "http://stest.package-test.info/paypal/index.php";//キャンセル次の戻り先
$res = CallShortcutExpressCheckout ($paymentAmount, $returnURL, $cancelURL,"品名");
var_dump($res);
if($res){
	RedirectToPayPal ($res );
}else{
	echo "Fail.";
}