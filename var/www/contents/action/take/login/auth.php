<?php

/*
*	管理画面のログイン処理
*/
	$this->addModel(array('take/Base'));
	$this->TakeBase->addModelTool('Login');

	$arrayLogin['loginID'] = $this->arrayAll['id'];

	$arrayLogin['pass'] = $this->TakeBase->changePass($this->arrayPost['pass'], $this->arraySetting['secretKey']);
	
	
	//ログインのチェック
	if ($this->TakeBase->auth($arrayLogin)){
		if (isset($this->arrayAll['redirect'])){
			$this->setRedirect($this->arrayAll['redirect']);
		}else{
			$this->setRedirect('message/list/');
		}

	}else{

		//$this->AdminBlockIp->addBlockIP();

		//ログイン失敗で、対象IPの失敗回数のカウントアップ
		$this->setRedirect('?error=1&type=' . getVar($this->arrayAll, 'type'));
	}
?>