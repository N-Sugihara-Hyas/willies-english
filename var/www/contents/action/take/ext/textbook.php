<?php
/*
*	トピックスリストの読み込み
*/
		//共通処理
		$this->getCommon();

		//モデル情報の読み込み
		$this->addModel(array('member/Base'));

		$objMember = $this->arrayPost;
		
		$this->MemberBase->commit($objMember);
		
		$this->setRedirect('ext/list/?mid=' . $objMember['id']);
?>