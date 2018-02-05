<?php


/***********************************************************
*	セッション関連のクラス
***********************************************************/
class SecurtySession{
var $arrayData;				/*セッションのデータ*/
var $key;					/*セッションの名前*/

	/***********************************************************
	*	コンストラクタ
	*	引数：デバックのフラグ
	***********************************************************/
	function SecurtySession($key){
		$this->key = $key;


		//携帯のための判定
		if (defined('SESSION_ID') ){
			if (SESSION_ID){
				session_id(SESSION_ID);
			}
		}


		if (!isset($_SESSION)){
			session_start();
		}



		$this->arrayData = array();
	}


	/***********************************************************
	*	セッションの追加(配列)
	***********************************************************/
	function commit(){
		$_SESSION[$this->key] = $this->arrayData;
	}

	/***********************************************************
	*	セッションの更新
	***********************************************************/
	function setData($key, $value){
		$_SESSION[$this->key][$key] = $value;
	}

	/***********************************************************
	*	セッションの取得
	***********************************************************/
	function getData(){
		if (isset($_SESSION[$this->key])){
			$this->arrayData = $_SESSION[$this->key];
		}

		return $this->arrayData;
	}

	/***********************************************************
	*	セッションIDの更新
	***********************************************************/
	function setReflash(){
		session_regenerate_id();
	}

	/***********************************************************
	*	セッションの初期化
	***********************************************************/
	function clear(){
		unset($_SESSION[$this->key]);
		$this->arrayData = array();
	}

}

?>