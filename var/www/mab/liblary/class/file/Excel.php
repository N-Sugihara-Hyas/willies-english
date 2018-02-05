<?php

require_once dirname(__FILE__) . '/../../opensorce/PHPExcel/PHPExcel.php';

/*
*	Excel生成のクラス
*/
class FileExcel extends PHPExcel{
var $fileName;
var $excel;
var $ver = 'Excel5';

	/*
	*	コンストラクタ
	*	@paramse $fileName ファイル名
	*/
	function __construct($fileName=''){
		$this->excel = new PHPExcel();
		$this->fileName = $fileName;
	}

	/*
	 * シートの設定
	 * @paramse @index インデックス $sheetName シートの名称
	 */
	function setSheet($index, $sheetName){
		$this->excel->setActiveSheetIndex($index);
		$this->sheet = $this->excel->getActiveSheet();
		$this->sheet->setTitle($sheetName);
	}

	function loadExcel($templateName){
		$reader = PHPExcel_IOFactory::createReader($this->ver);
		$this->excel = $reader->load($templateName);
	}

	function download(){
		//ヘッダを設定する
		header('Content-Type: application/octet-stream');
		//ダウンロードするときのファイル名を指定する
		header('Content-Disposition: attachment;filename="' . $this->fileName . '"');

		$writer = PHPExcel_IOFactory::createWriter($this->excel, $this->ver);
		$writer->save('php://output');
	}

}

?>