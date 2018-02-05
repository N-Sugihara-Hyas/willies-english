<?php
/*
*	ログイン画面
*/

		//モデル情報の読み込み
		$this->addModel(array('member/Base'));

		//ログイン
		$this->MemberBase->addModelTool('Login');

		$this->set('error', getVar($this->arrayAll, 'error'));


?>