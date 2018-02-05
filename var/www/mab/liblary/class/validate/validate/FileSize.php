<?php

	/*
	*	ファイルサイズ
	*	@params strCheck 入力値 arrayError エラー内容 key Formのキー
	*	@return エラーチェックにかかればエラー内容　かからなければfalse
	*/
	$self->parent->FileSize = function($strCheck, $arrayError, $key='') use($self){
		if (isset($_FILES)){
			if (isset($_FILES[$key]) ){
				if ($_FILES[$key]['size'] > $arrayError['size']){
					return $arrayError['message'];
				}
			}
		}

		return false;
	};
?>