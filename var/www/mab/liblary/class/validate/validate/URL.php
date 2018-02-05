<?php

	/*
	*	正常なURLかのチェック
	*	@params strCheck 入力値 arrayError エラー内容 key Formのキー
	*	@return エラーチェックにかかればエラー内容　かからなければfalse
	*/
	$self->parent->URL = function($strCheck, $arrayError, $key='') use($self){
		if ($strCheck){
			if (!preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $strCheck)) {
				return $arrayError['message'];
			}
		}

		return false;
	};

?>