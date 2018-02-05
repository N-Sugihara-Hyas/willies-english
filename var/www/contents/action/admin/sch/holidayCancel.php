<?php

/***********************************************************
*	項目の削除
*/

	//共通処理
	$this->getCommon();

	//モデル情報の読み込み
	$this->addModel(array('take/Reserve', 'take/Cancel', 'member/Cancel', 'member/Base', 'master/AdminNews', 'take/Base', 'member/Point'));
	
	if ($this->uid){
		$this->TakeReserve->addQuery('id', $this->uid);
		$this->TakeReserve->delData();
	}

	$this->setRedirect(urldecode($this->arrayAll['redirect']));
?>