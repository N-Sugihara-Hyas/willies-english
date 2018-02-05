<?php

/*
*	ログイン処理
*/
	$this->addModel(array('member/Base'));
	$this->MemberBase->addModelTool('Login');


	$arrayLogin['email'] = $this->arrayAll['email'];
	$arrayLogin['pass'] = $this->MemberBase->changePass($this->arrayPost['pass'], $this->arraySetting['secretKey']);

	//ログインのチェック
	if ($this->MemberBase->auth($arrayLogin)){

		
		$this->setRedirect('mypage/');
	}else{
		//ログイン失敗で、対象IPの失敗回数のカウントアップ
		//$this->AdminBlockIp->addBlockIP();
		$this->setRedirect('login/?error=1');
	}
?>