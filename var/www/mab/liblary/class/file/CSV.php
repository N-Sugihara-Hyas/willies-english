<?php

/***********************************************************
*	CSV関連のクラス
*/
class classCSV{
var $fileName;
var $csv;
var $arrayData;

	/***********************************************************
	*	コンストラクタ
	*	$flgType 1=ファイルで読み込み 2=データで読み込み 3=POSTから読み込み
	*/
	function classCSV($flgType=1, $value=''){
		if ($flgType == 3){
			$this->fileName = $_FILES[$value]['tmp_name'];
		}else if($flgType == 2){
			$this->csv = $value;
		}else{
			$this->fileName = $value;
		}
	}

	/***********************************************************
	*	データの設定
	*/
	function setData($data){
		$this->csv = $data;
	}

	/***********************************************************
	*	データの変換
	*/
	function changeData(){
		$this->arrayData = explode(',', $this->csv);

		return $this->arrayData;
	}

}