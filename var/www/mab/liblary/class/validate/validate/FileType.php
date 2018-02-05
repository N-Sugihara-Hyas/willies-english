<?php

	/*
	*	ファイルの種類
	*	@params strCheck 入力値 arrayError エラー内容 key Formのキー
	*	@return エラーチェックにかかればエラー内容　かからなければfalse
	*/
	$self->parent->FileType = function($strCheck, $arrayError, $key=''){
		if (isset($_FILES)){
			if (!empty($_FILES[$key]['name']) ){
				$arrayType = explode(',', $arrayError['num']);

				foreach ($arrayType as $item){
					$item = str_replace('/', '\/', $item);
					
					if (preg_match("/" . $item . "(.*?)/", $_FILES[$key]['type'])){
						return false;
					}
				}

				return $arrayError['message'];
			}
		}

		return false;
	};
?>