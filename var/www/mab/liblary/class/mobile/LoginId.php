<?php

require_once dirname(__FILE__) . '/../db/Db.php';

/***********************************************************
*	ログイン(端末IDでの自動ログイン判定)
***********************************************************/
class classLoginID extends classDB{
	var $arrayData;
	var $sql;
	var $flgDebug;

	/***********************************************************
	*	コンストラクタ
	*	デバックモード,テーブル名,セッションの名称
	***********************************************************/
	function classLoginID($flgDebug, $tableName, $arrayKou, $arrayData){
		$this->classDB();

		$this->flgDebug = $flgDebug;

		foreach ($arrayKou as $item){
			$this->sql.=' AND ' . $item . '=?';
		}


		$this->arrayData = $arrayData;
		$this->strTableName = $tableName;
	}

	/***********************************************************
	*	ログイン対象の更新箇所の設定
	*	引数:DBの検索対象,DBへの検索データ
	***********************************************************/
	function setLoginReflesh($strTime, $ip){
		$this->arrayReflasehData['strTime'] = $strTime;
		$this->arrayReflasehData['ip'] = $ip;
	}

	/***********************************************************
	*	ログイン対象の情報を見て、ログイン
	*	返り値：true,false
	***********************************************************/
	function checkLogin(){
		if ($this->checkLoginNow()){
			return true;
		}else{
			return false;
		}
	}

	/***********************************************************
	*	ログインした情報を取得
	*	返り値：ログインした情報
	***********************************************************/
	function getData(){
		return $this->arrayInfo;
	}

	/***********************************************************
	*	SIDを見て、ログインが継続されているかの確認
	*	返り値：true,false
	***********************************************************/
	function checkLoginNow(){
		$this->arrayInfo = $this->getDataSingle('WHERE 1' . $this->sql, $this->arrayData);
		if ($this->arrayInfo){
			$this->setLoginInfo('1' . $this->sql, $this->arrayData);
			return true;
		}

		return false;
	}

	/***********************************************************
	*	見つかった情報のSIDと更新時間を更新
	*	引数：更新情報の検索条件
	***********************************************************/
	function setLoginInfo($strWhere, $uID){
		$set = $this->arrayReflasehData['strTime'] . '=?,';
		$set.= $this->arrayReflasehData['ip'] . '=?';

		$arrayData = array();

		array_push($arrayData, date('Y-m-d H:i:s'));
		array_push($arrayData, $_SERVER['REQUEST_ADDR']);
		array_push($arrayData, $uID);
		
		$this->setDataSimple($set, $strWhere, $arrayData);
	}

	/***********************************************************
	*	ログアウト処理
	*	引数：なし
	***********************************************************/
	function setLogout(){

		$this->cDb->delData($this->arrayReflasehData['strSid'] . '=?' , array($this->getSession()), $this->strTableSession);
		$this->setSession('');
	}
}
?>