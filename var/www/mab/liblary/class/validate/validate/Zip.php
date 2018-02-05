<?php

	/*
	*	正常な郵便番号かのチェック
	*	@params strCheck 入力値 arrayError エラー内容 key Formのキー
	*	@return エラーチェックにかかればエラー内容　かからなければfalse
	*/
	$self->parent->Zip = function($strCheck, $arrayError, $key='') use($self){
		if ($strCheck){
			if (!preg_match("/^\d{3}\-\d{4}$/", $strCheck)) {
					return $arrayError['message'];
			}
		}

		return false;
	};

?>