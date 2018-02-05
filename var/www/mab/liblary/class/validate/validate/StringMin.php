<?php

	/*
	*	文字数の下限チェック
	*	@params strCheck 入力値 arrayError エラー内容 key Formのキー
	*	@return エラーチェックにかかればエラー内容　かからなければfalse
	*/
	$self->parent->StringMin = function($strCheck, $arrayError, $key=''){
		if (mb_strlen($strCheck, 'utf-8') < $arrayError['num']){
			return $arrayError['message'];
		}

		return false;
	};

?>