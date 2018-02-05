<?php

	/*
	*	フリーメールアドレスではないかのチェック
	*	@params strCheck 入力値 arrayError エラー内容 key Formのキー
	*	@return エラーチェックにかかればエラー内容　かからなければfalse
	*/
	$self->parent->MailNonFree = function($strCheck, $arrayError, $key='') use($self){
		require_once dirname(__FILE__) . '/../mail/Free.php';

		$MailFree = new MailFree();
		if (!$MailFree->isNotFree($strCheck) ){

			return $arrayError['message'];
		}

	};

?>