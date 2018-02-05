<?php

/*
*	言語処理
*/
class InoutputLanguage{

	/*
	*	コンストラクタ
	*	@params $file 設定ファイル $la デフォルトの言語
	*/
	function __construct($file, $la='ja'){
		$this->file 	= $file;
		$this->default = $la;

		if (($la) && ($la != 'ja')){
			require_once $file . $this->default . '.php';
			$this->arrayLanguage = $arrayLanguage;
		}
	}

	function change($key, $ja){		
		if (isset($this->arrayLanguage[$key]) ){
			echo $this->arrayLanguage[$key];
		}else{
			echo $ja;
		}
	}

}

?>