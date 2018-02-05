<?php

	/*
	*	カタカナかのチェック
	*	@params strCheck 入力値 arrayError エラー内容 key Formのキー
	*	@return エラーチェックにかかればエラー内容　かからなければfalse
	*/
	$self->parent->JapanKana($strCheck, $arrayError, $key='') use($self){

		if (!preg_match("/^[ァ-ヶ]+$/u",$strCheck)) {
			return $arrayError['message'];
		}

		return false;
	};

?>