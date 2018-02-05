<?php

/*
*	管理画面のログイン画面
*/

	//追加でrequireするもの
	$this->addModel(array('admin/User'));
	$this->addLiblary(array('securty/Code'));


	/*if ($this->_checkAuto()){
		//自動ログイン
		$this->setRedirect('login/master');
	}*/

	$this->set('arrayAll', $this->arrayAll);
	$this->set('error', getVar($this->arrayAll, 'error'));
	$this->set('type', getVar($this->arrayAll, 'type'));
?>