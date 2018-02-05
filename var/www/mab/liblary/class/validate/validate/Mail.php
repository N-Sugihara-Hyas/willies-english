<?php

	/*
	*	正常なメールアドレスかのチェック
	*	@params strCheck 入力値 arrayError エラー内容 key Formのキー
	*	@return エラーチェックにかかればエラー内容　かからなければfalse
	*/
	$self->parent->Mail = function($strCheck, $arrayError, $key='') use ($self){

		if ($strCheck){
			if (preg_match('/[^A-Za-z0-9_\@\.\-]/', $strCheck)) {
				return $arrayError['message'];
			}else if (! preg_match('/.+\@.+\..+/', $strCheck)) {
				return $arrayError['message'];
			}else if (preg_match('/\@\.|\.$/', $strCheck)) {
				return $arrayError['message'];
			}
		}

		return false;
	};

?>