<?php

require_once ("paypalfunctions.php");
/*
 状態変更サンプル
 同じ状態には出来ないので、 Cancel後にcancelするとエラ－になります。
 */
//Cancel   キャンセル
//Suspend　一時停止
//Reactivate　再開
//$res = change_subscription_status("I-2REHBR12FR6V","Suspend");

$res = check_status("I-4DC2W7EE4WUP");

switch($res["STATUS"]){
	case "Active":echo "有効な状態です。";break;
	case "Pending":echo "未決済の状態です。";break;
	case "Cancelled":echo "キャンセル済みの状態です。";break;
	case "Suspended":echo " 一時停止の状態です。";break;
	case "Expired":echo "請求サイクルが終了した状態です。";break;
}









