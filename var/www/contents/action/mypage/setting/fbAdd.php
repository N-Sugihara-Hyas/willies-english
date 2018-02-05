<?php
/*
*	ログイン画面
*/

		//モデル情報の読み込み
		$this->getCommon();

		//お気に入りに設定
		$this->MemberBase->addQuery('id', $this->arrayUser['id']);
		$this->MemberBase->setData(array('take_base_id_fb' => $this->uid));
		
		$this->setRedirect('mypage');
?>