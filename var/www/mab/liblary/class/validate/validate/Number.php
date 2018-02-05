<?php

	/*
	*	半角数字かのチェック
	*	@params strCheck 入力値 arrayError エラー内容 key Formのキー
	*	@return エラーチェックにかかればエラー内容　かからなければfalse
	*/
	$self->parent->Number = function($strCheck, $arrayError, $key='') use($self){

		if (preg_match('/[^0-9]/', $strCheck)){
			return $arrayError['message'];
		}
		return false;
	};

?>