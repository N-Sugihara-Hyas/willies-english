<?php

	/*
	*	確認用のチェック
	*	@params strCheck 入力値 arrayError エラー内容 key Formのキー
	*	@return エラーチェックにかかればエラー内容　かからなければfalse
	*/
	$self->parent->Conf = function($strCheck, $arrayError, $key='') use ($self){

		if ($strCheck != $self->arrayInput[$arrayError['conf']]){
			return $arrayError['message'];
		}

		return false;
	};

?>