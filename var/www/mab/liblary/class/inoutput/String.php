<?php
/*
*	指定した文字データの処理
*/
class InoutputString{
var $strString;
var $strLog;

	/*
	*	コンストラクタ
	*/
	function String($strString=''){
		$this->strString 	= $strString;
	}

	/*
	*	ランダムな文字列の取得
	*	@params $numLengthRequired 文字列の長さ
	*/
	function getRandomString($numLengthRequired = 26, $original=''){
			if (!$original){
		    $sCharList = "abcdefghijklmnopqrstuvwxyz0123456789";
			}else{
		    $sCharList = $original;
			}

	    mt_srand();
	    $sRes = "";
	    for($i = 0; $i < $numLengthRequired; $i++)
	        $sRes .= $sCharList{mt_rand(0, strlen($sCharList) - 1)};

	    return $sRes;
	}

	/***********************************************************
	*	ランダムな文字列の取得
	*	デバックモード化のフラグ
	***********************************************************/
	function getRandomNumber($numLengthRequired = 26){
	    $sCharList = "0123456789";
	    mt_srand();
	    $sRes = "";
	    for($i = 0; $i < $numLengthRequired; $i++)
	        $sRes .= $sCharList{mt_rand(0, strlen($sCharList) - 1)};

	    return $sRes;
	}

	/***********************************************************
	*	配列データを一つの文字列にする
	*	戻り値：文字列
	***********************************************************/
	function getArrayToString($arrayString){

		foreach ($arrayString as $item){
			$str.= $item;
		}

		return $str;
	}

	/***********************************************************
	*	配列データを,形式の一つの文字列にする
	*	戻り値：文字列
	***********************************************************/
	function getArrayToStringCsv($arrayString){

		foreach ($arrayString as $item){
			$str.= $item . ',';
		}

		$str = substr($str, 0, mb_strlen($str) - 1);

		return $str;
	}

	/***********************************************************
	*	CSVを配列に変換
	*	戻り値：配列
	***********************************************************/
	function getStringCsvToArray($strCsv){

		$arrayCsv = explode(',', $strCsv);

		return $arrayCsv;
	}

	/***********************************************************
	*	[%%]の形式で置換
	*	戻り値：置換後の文字
	***********************************************************/
	function changeReplaceNormal($key, $value, $string){
		$string = str_replace('[% ' . $key . ' %]', $value, $string);

		return $string;
	}

	/***********************************************************
	*	都道府県の取得
	*	引数：都道府県の指定
	***********************************************************/
	function getArea($numArea=''){
		$arrayArea = Array(
'北海道','青森県','岩手県','宮城県','秋田県','山形県','福島県','茨城県','栃木県',
'群馬県','埼玉県','千葉県','東京都','神奈川県','新潟県','富山県','石川県','福井県',
'山梨県','長野県','岐阜県','静岡県','愛知県','三重県','滋賀県','京都府','大阪府',
'兵庫県','奈良県','和歌山県','鳥取県','島根県','岡山県','広島県','山口県','徳島県',
'香川県','愛媛県','高知県','福岡県','佐賀県','長崎県','熊本県','大分県','宮崎県',
'鹿児島県','沖縄県'
		);

		if (strlen($numArea) >= 1){
			return $arrayArea[$numArea];
		}else{
		    return $arrayArea;
		}
	}

	/***********************************************************
	*	都道府県の日本名からIDを取得
	*	引数：都道府県の指定
	***********************************************************/
	function getAreaString($areaName=''){
		$arrayArea = Array(
'北海道','青森県','岩手県','宮城県','秋田県','山形県','福島県','茨城県','栃木県',
'群馬県','埼玉県','千葉県','東京都','神奈川県','新潟県','富山県','石川県','福井県',
'山梨県','長野県','岐阜県','静岡県','愛知県','三重県','滋賀県','京都府','大阪府',
'兵庫県','奈良県','和歌山県','鳥取県','島根県','岡山県','広島県','山口県','徳島県',
'香川県','愛媛県','高知県','福岡県','佐賀県','長崎県','熊本県','大分県','宮崎県',
'鹿児島県','沖縄県'
		);

		foreach ($arrayArea as $key => $value){
			if ($value == $areaName){
				return $key;
			}
		}
	}

	/*
	*	文字列内の変数(({$形式}))を置換
	*
	*	@params $string 変換元 $arrayData 変換する変数の配列
	*	@return 変換後の文字列
	*/
	function changeStringVar($string, $arrayData){
		foreach ($arrayData as $key => $value){
			$string = str_replace('({$' . $key . '})', $value, $string);
		}

		return $string;
	}

}

?>