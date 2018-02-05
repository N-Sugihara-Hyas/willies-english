<?php

require 'View.php';

/*
*	全てのモジュールの根底クラス
*/
class BaseAction extends BaseView{
var $arrayPost;						//POST
var $arrayGet;						//GET
var $arrayAll;						//上記の両方
var $arrayDir;						//ディレクトリの場所
var $arraySetting;				//基本設定
var $uid = null;

var $encodeInput = 	'UTF-8';
var $encodeOutput = 'UTF-8';

	/*
	*	アクションの生成
	*	@params $arrayAction アクション情報 $arrayParams　パラメータ情報 $arrayDir ディレクトリ設定情報 $arraySetting 基本設定情報
	*/
	function __construct($arrayAction, $arrayParams, $arrayDir, $arraySetting){
		$this->resTime = microtime(true);

		$this->arrayAction	= $arrayAction;
		$this->arrayParams = $arrayParams;
		if (isset($arrayParams[0])){$this->uid = $arrayParams[0];}

		//設定値の受け渡し
		$this->arrayDir 	= $arrayDir;
		$this->arraySetting	= $arraySetting;

		$this->common();

		$this->setInput();

		//プログラムのスタート
		require_once $arrayAction['requireAction'];

		$this->commonAffter();

		//ページの表示
		$this->setShow($this->arrayAction['a']);

	}

	/*
	*	入力値の処理
	*/
	function setInput(){
		$this->arrayPost = $_POST;
		$this->arrayGet = $_GET;
		$this->arrayAll = $_REQUEST;
	}

	/*
	*	コアのライブラリを追加
	*	@params $arrayRequire コアのライブラリを配列で指定
	*/
	function addLiblary($liblary){

		//コア部分のライブラリの読み込み
		if (is_array($liblary) ){
			if ($liblary){
				foreach ($liblary as $item){
					require_once $this->arrayDir['dirClass'] . $item . '.php';
				}
			}
		}else{
			require_once $this->arrayDir['dirClass'] . $liblary . '.php';
		}
	}

	/*
	*	コンテンツ毎のライブラリを追加
	*	@params $arrayRequire コンテンツごとのライブラリを配列で指定
	*/
	function addPlugin($liblary){
		if (is_array($liblary) ){
			//コンテンツ部分のライブラリの読み込み
			if ($liblary){
				foreach ($liblary as $item){
					require_once $this->arrayDir['dirContents'] . 'liblary/' . $item . '.php';
				}
			}
		}else{
			require_once $this->arrayDir['dirContents'] . 'liblary/' . $liblary . '.php';
		}
	}

	/*
	*	モデルを追加
	*	@params モデルのライブラリを配列で指定
	*/
	function addModel($arrayModel){

		foreach ($arrayModel as $modelName){
			$model = getModel($modelName);
			$modelName = $model->modelName;
			$this->$modelName = $model;
			$this->$modelName->arrayAction = $this->arrayAction;
			$this->$modelName->arrayDir = $this->arrayDir;
			$this->$modelName->arraySetting = $this->arraySetting;
		}


		return $modelName;
	}

	/*
	*	バリデートを追加
	*	@params バリデートのライブラリを配列で指定
	*/
	function addValidate($arrayValidate){

		foreach ($arrayValidate as $validateName){
			$validate = getValidate($validateName);
			$validateName = $validate->validateName;

			$this->$validateName = $validate;
			$this->$validateName->arrayAction = $this->arrayAction;
			$this->$validateName->arrayDir = $this->arrayDir;
			$this->$validateName->arraySetting = $this->arraySetting;
			$this->$validateName->validateName = $validateName;
		}

		return $validateName;
	}


	/*
	*	全てで実行するプログラム
	*/
	function common(){

	}

	function commonAffter(){

	}

	/*
	*	リダイレクト処理
	*	@params $action 遷移先
	*/
	function setRedirect($action){
		$action = str_replace($this->dirRoot, '', $action);


		if ($this->dirRoot){
			if ($action[0] == '/'){$action = substr($action, 1, strlen($action));}

			header('Location:/' . $this->dirRoot . '/' . $action);
		}else{
			header('Location:/' . $action);
		}
		exit();
	}


}
?>
