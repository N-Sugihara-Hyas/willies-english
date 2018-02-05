<?php

	/*
	*	日本語かのチェック
	*	@params strCheck 入力値 arrayError エラー内容 key Formのキー
	*	@return エラーチェックにかかればエラー内容　かからなければfalse
	*/
	$self->Japan = function($strCheck, $arrayError, $key='') use($self){

		if (!preg_match("/^[ぁ-んァ-ヶー一-龠０-９]+$/u",$strCheck)) {
			return $arrayError['message'];
		}

		return false;
	};

?>