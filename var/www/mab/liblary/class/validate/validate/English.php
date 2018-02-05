<?php

	/*
	*	半角英数字かのチェック
	*	@params strCheck 入力値 arrayError エラー内容 key Formのキー
	*	@return エラーチェックにかかればエラー内容　かからなければfalse
	*/
	$self->parent->English = function($strCheck, $arrayError, $key='') use($self){

		if (preg_match('/[^A-Za-z0-9_\@\.\:\-\/ ]/', $strCheck)){
			return $arrayError['message'];
		}
		return false;
	};

?>