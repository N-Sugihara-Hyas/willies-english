<?php

require_once dirname(__FILE__) . '/../../PEAR/XML/Parser.php';
require_once dirname(__FILE__) . '/../../PEAR/XML/Serializer.php';
require_once dirname(__FILE__) . '/../../PEAR/XML/Unserializer.php';
require_once dirname(__FILE__) . '/../../PEAR/XML/Util.php';

/***********************************************************
*	XMLの入出力を扱うクラス
***********************************************************/
	class FileXml{

		var $arrayData;					/*配列でXMLデータの保持*/
		var $strResult;					/*文字列でXMLデータの保持*/
		var $arrayOptions;				/*配列でXMLデータのオプションを保持*/

		var $url;						/*情報を取得する場合のURL先*/

		/***********************************************************
		*	コンストラクト
		***********************************************************/
		function FileXml($url=''){
			$this->arrayOptions = array( 
			  "mode" => "simplexml" ,
			  XML_SERIALIZER_OPTION_INDENT => "  ", 
			  XML_SERIALIZER_OPTION_XML_ENCODING => 'UTF-8', 
			  XML_SERIALIZER_OPTION_XML_DECL_ENABLED => TRUE, 
			  XML_SERIALIZER_OPTION_ROOT_NAME => 'swf', 
			  XML_SERIALIZER_OPTION_DEFAULT_TAG => 'item',
			  'parseAttributes' => true,
			  'attributesArray' => '_attributes'
			);

			$this->url = $url;
		}

		/***********************************************************
		*	指定されたURLから情報の取得
		***********************************************************/
		function getDataArray($url=''){
			if ($url){$this->url = $url;}

			$xml = file_get_contents($this->url);

			$unserializer =new XML_Unserializer($this->arrayOptions);

			if (PEAR::isError($unserializer->unserialize($xml))) {
				return false;
			}

			$this->arrayData = $unserializer->getUnserializedData();

			return $this->arrayData;
		}

		/***********************************************************
		*	配列の設定とXML形式の文字列に変換
		***********************************************************/
		function changeArrayStringData($arrayData){
			$serializer = new XML_Serializer($this->arrayOptions); 
			$serializer->serialize($arrayData); 
			$this->strResult = $serializer->getSerializedData();

			return $this->strResult;
		}


		/***********************************************************
		*	データを配列で返す
		***********************************************************/
		function getData(){
			return $this->arrayData;
		}

		/***********************************************************
		*	取得している情報を画面に表示
		***********************************************************/
		function outView(){
			header("Content-Type: text/xml; charset=utf-8"); 
			echo $this->strResult;

		}

		/***********************************************************
		*	取得している情報をファイルに出力
		***********************************************************/
		function outFile($url=''){
			if ($url){$this->url = $url;}

			$fp = fopen($this->url, 'w');
			fwrite($fp, $this->strResult);
			fclose($fp);
		}
	}
?>