<?php

/*
*	管理画面のログイン処理
*/
	$this->addModel(array('admin/User'));
	$this->AdminUser->addModelTool('Login');

	$arrayLogin['loginID'] = $this->arrayPost['id'];
	$arrayLogin['pass'] = $this->AdminUser->changePass($this->arrayPost['pass'], $this->arraySetting['secretKey']);



	//ログインのチェック
	if ($this->AdminUser->auth($arrayLogin)){
		$this->setRedirect('messageTake/list/');
	}else{

		//$this->AdminBlockIp->addBlockIP();

		//ログイン失敗で、対象IPの失敗回数のカウントアップ
		$this->setRedirect('?error=1&type=' . getVar($this->arrayAll, 'type'));
	}
?>