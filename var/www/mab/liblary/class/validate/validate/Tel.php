<?php

	/*
	*	正常な電話番号かのチェック
	*	@params strCheck 入力値 arrayError エラー内容 key Formのキー
	*	@return エラーチェックにかかればエラー内容　かからなければfalse
	*/
	$self->parent->Tel = function($strCheck, $arrayError, $key='') use ($self){
		if ($strCheck){
			if (!preg_match("/^\d{2,4}\-\d{2,4}-\d{4}$/", $strCheck)) {
					return $arrayError['message'];
			}
		}

		return false;
	};

?>