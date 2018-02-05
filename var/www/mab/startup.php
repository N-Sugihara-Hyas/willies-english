<?php
	
	
	//デバックモードか？
	if (DEBUG_MODE == 1){
		ini_set('display_errors', 'On');
		error_reporting(E_ALL);
	}else{
		ini_set('display_errors', 'Off');
	}

	/*
	*	プログラムに必要な設定
	*/	
	$arrayDir['dirClass']		= $arrayDir['dirProgram'] . 'liblary/class/';				//クラス群の置き場所
	$arrayDir['dirAction']		= $arrayDir['dirContents'] . 'action/';						//コンテンツ群の置き場所
	$arrayDir['dirValidate']	= $arrayDir['dirContents'] . 'validate/';					//エラーチェック群の置き場所
	$arrayDir['dirHtml']		= $arrayDir['dirContents'] . 'html/';								//HTML群の置き場所
	$arrayDir['dirTmp']			= $arrayDir['dirContents'] . 'tmp/';								//キャッシュ関連の置き場所
	$arrayDir['dirLiblary']		= $arrayDir['dirContents'] . 'plugin/';						//プラグインの置き場所
	$arrayDir['dirCustom']		= $arrayDir['dirContents'] . 'custom/';						//コアのカスタマイズファイルの置き場所
	$arrayDir['dirConf']		= $arrayDir['dirContents'] . 'conf/';					//コアのカスタマイズファイルの置き場所
	
	//全共通で使用する関数の定義
	require_once  $arrayDir['dirProgram'] . 'liblary/function.php';

	ini_set('include_path', dirname(__FILE__) . '/liblary/PEAR/');
	
	//Webからのアクションの取得
	$url = 'index';
	
	if (!empty($_REQUEST["urls"])){
		$url = $_REQUEST["urls"];
	}else{
		if (isset($_SERVER["REDIRECT_URL"])){
			$url = $_SERVER["REDIRECT_URL"];
			$url = substr($url, 1, strlen($url));
		}
	}

	$url = str_replace('.php', '', $url);
	$url = str_replace('.html', '', $url);

	//cron動作のための対応
	if (!empty($_SERVER["argv"][1])){
		$url = $_SERVER["argv"][1];
		$arraySetting['isCron'] = true;
	}

	//基本パラメータの取得
	if (empty($url)){$url = '/';}

	$arrayParams = explode('/', $url);

	if (isset($arrayActionDir[$arrayParams[0]])){
		$arrayActionDirSelect = $arrayActionDir[$arrayParams[0]];
	}else{
		$arrayActionDirSelect = $arrayActionDir['default'];
	}

	$arrayAction['dir'] ='';
		
	//configで指定がある場合	
	if (isset($arrayActionDirSelect[0])){	
		for ($i = 0; $i < $arrayActionDirSelect[0]; $i++){			
			if (!empty($arrayParams[0])){
				$arrayAction['dir'].= $arrayParams[0] . '/';
				array_splice($arrayParams, 0, 1);
			}
		}
	}
	
	
	//アクションを設定
	if (empty($arrayParams[0])){$arrayAction['a'] = 'index';}else{$arrayAction['a'] = $arrayParams[0];array_splice($arrayParams, 0, 1);}

	$action = $arrayDir['dirAction'] . $arrayAction['dir'] . $arrayAction['a'] . '.php';


	if (!file_exists($action) ){
		//アクションが無い場合は、pageアクションを読み込む
		$action = $arrayDir['dirAction'] . 'page.php';
		array_unshift($arrayParams, $arrayAction['a']);
	}

	//コントロールの基盤の読み込み
	require_once $arrayDir['dirProgram'] . 'base/Action.php';
	require_once $arrayDir['dirCustom'] . $arrayActionDirSelect[1] . '.php';

	$class = 'Custom' . $arrayActionDirSelect[1];
	$arrayAction['requireAction'] = $action;
		
	//Actionクラスの初期設定
	$Action = new $class($arrayAction, $arrayParams, $arrayDir, $arraySetting);
?>