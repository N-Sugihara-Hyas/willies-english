<?php

	/*
	*	各ディレクトリを絶対パスで設定
	*/
	$arrayDir['dirRoot'] 	 = dirname(__FILE__) . '/';							//ルートディレクトリの指定
	$arrayDir['dirProgram']  = $arrayDir['dirRoot'] . 'mab/';				//プログラム本体の置き場所を絶対パスで指定
	$arrayDir['dirView'] 	 = $arrayDir['dirRoot'] . 'html/';					//表示領域
	$arrayDir['dirContents'] = $arrayDir['dirRoot'] . 'contents/';				//コンテンツの置き場所
	$arrayDir['dirBackUpTo'] = $arrayDir['dirContents'] . '_backup/first/';		//バックアップの置き場所

	/*
	*	基本設定
	*/
	$arraySetting = Array(
		'domain' => 'williesenglish.jp',						//ドメイン
		'domainEmail' => 'willies.jp',						//ドメイン
		'email' => 'company@williesenglish.com',		//管理者へのメールの送り先
		'email2' => 'company@williesenglish.com',		//管理者へのメールの送り先
		'email3' => 'company@williesenglish.com',		//管理者へのメールの送り先
		'email4' => 'company@williesenglish.com',		//管理者へのメールの送り先
		'from' => 'company@williesenglish.com',		//メールの送り元
		'outEncoding' => 'UTF-8',
		'title' => 'Willies English',
		'secretKey' => 'jlkoimoce',
		'timeStart' => 0,
		'timeEnd' => 23,
		'countDaily' => 5,
		'maxSchedule' => 31,		//Aプランの確保期間
		'maxReserve' => 3,			//Bプランで何日後まで予約可能か
		'maxCountLesson' => 10,		//Bプランの最大ポイント数
		'tax' => 0.08,						//消費税率
		'level' => 7,							//レベルの最大値
	);

	if (!isset($_SERVER['HTTP_HOST'])){
		$_SERVER['HTTP_HOST'] = $arraySetting['domain'];
	}else{
		$arraySetting['domain'] = $_SERVER['HTTP_HOST'];
	}

	require_once 'db.php';

	/*
	*	ディレクトリ区切りの設定
	*/
	$arrayActionDir = array(
		'default' => array(0, 'Front'),
		'api' => array(1, 'Front'),
		'admin'	=> array(2, 'AdminPlus'),
		'take'	=> array(2, 'Take'),
		'company'	=> array(2, 'Company'),
		'card'	=> array(2, 'FrontCard'),
		'application_form' => array(1, 'Front'),
		'login' => array(1, 'Front'),
		'mypage' => array(2, 'Front'),
		'cron' => array(1, 'Front'),
		'pay' => array(1, 'Front'),
	);

	require_once $arrayDir['dirProgram'] . 'startup.php';


?>