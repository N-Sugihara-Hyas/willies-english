<?php

	/*
	*	文字数の上限チェック
	*	@params strCheck 入力値 arrayError エラー内容 key Formのキー
	*	@return エラーチェックにかかればエラー内容　かからなければfalse
	*/
	$self->parent->StringMax = function($strCheck, $arrayError, $key=''){
			$count = strlen(mb_convert_encoding($strCheck, 'SJIS', 'UTF-8'));

			if ($count > $arrayError['num']){
				return $arrayError['message'];
			}

		return false;
	};

?>