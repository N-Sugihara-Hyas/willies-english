<?php

/*
*	管理画面のログイン処理
*/
	$this->addModel(array('company/Base'));
	$this->CompanyBase->addModelTool('Login');

	$arrayLogin['loginID'] = $this->arrayAll['id'];

	if (!isset($this->arrayAll['isMaster'])){
		$arrayLogin['pass'] = $this->CompanyBase->changePass($this->arrayPost['pass'], $this->arraySetting['secretKey']);
	}
	
	
	//ログインのチェック
	if ($arrayUser = $this->CompanyBase->auth($arrayLogin)){		
		if (isset($this->arrayAll['redirect'])){
			$this->setRedirect($this->arrayAll['redirect']);
		}else{
			$this->setRedirect('customer/list/');
		}

	}else{

		//$this->AdminBlockIp->addBlockIP();

		//ログイン失敗で、対象IPの失敗回数のカウントアップ
		$this->setRedirect('?error=1&type=' . getVar($this->arrayAll, 'type'));
	}
?>