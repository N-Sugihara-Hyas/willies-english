<?php

/*
*	クッキー関連のクラス
*/
class SecurtyCookie{
var $flgDebug;											//デバックモードか？
var $log;												//エラーログ
var $key;												//クッキーの名前
var $time=360000000;									//クッキーを保持する時間
var $arrayData;											//クッキーのデータ

	/*
	*	コンストラクタ
	*/
	function SecurtyCookie($key){
		$this->key = $key;
	}


	/*
	*	クッキーの設定
	*/
	function addData($arrayData){
		$strSecurtyCookie = '';
		foreach ($arrayData as $key => $item){
			$strSecurtyCookie.= $key . '==' . $item . '&';
		}

		$this->arrayData = $arrayData;

		$strCookie = substr($strSecurtyCookie, 0, strlen($strSecurtyCookie) - 1);
		setCookie($this->key, $strSecurtyCookie, time() + $this->time, '/');
	}

	/*
	*	クッキーの取得
	*/
	function getData(){		
		if (isset($_COOKIE[$this->key])){
			$arrayCookie = explode('&', $_COOKIE[$this->key]);

			foreach ($arrayCookie as $item){
				if ($item){
					list($key, $value) = explode('==', $item);
					$this->arrayData[$key] = $value;
				}
			}

			return $this->arrayData;
		}

		return false;
	}

	/*
	*	クッキーの設定
	*/
	function commit(){
		$this->addData($this->arrayData);
	}

	/*
	*	クッキーの初期化
	*/
	function clear(){
		setCookie($this->key, '');
	}

}

?>