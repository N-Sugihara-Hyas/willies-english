<?php

	/*
	*	空白ではないかのチェック
	*	@params strCheck 入力値 arrayError エラー内容 key Formのキー
	*	@return エラーチェックにかかればエラー内容　かからなければfalse
	*/
	$self->parent->NonSpace = function($strCheck, $arrayError, $key='') use ($self){

		if (is_array($strCheck) ){

		}else{
			if (!strlen($strCheck)){
				if (empty($_FILES[$key]['name'])){
					return $arrayError['message'];
				}
			}
		}

		return false;
	};

?>