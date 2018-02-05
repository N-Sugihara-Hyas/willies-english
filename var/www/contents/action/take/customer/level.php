<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array('member/Base'));

		//共通処理
		$this->getCommon();

		$this->MemberBase->addQuery('id', $this->arrayAll['id']);		
		$this->MemberBase->setData($this->arrayPost);
						
		$this->setRedirect('take/customer/list/');
?>