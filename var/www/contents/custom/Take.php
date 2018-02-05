<?php

/*
*	管理画面用のベースクラスの改造版
*/
class CustomTake extends BaseAction{
var $dirRoot = 'take';


	function common(){
		$this->addLiblary('inoutput/Language');
		$this->Lang = new InoutputLanguage($this->arrayDir['dirProgram'] . 'template/admin/la/', 'ja');

	}

	/*
	*	管理画面の表示が行われる全てで処理
	*/
	function getCommon(){
		$this->addModel(array('take/Base'));

		$this->TakeBase->addModelTool('Login');

		if (!$this->arrayUser = $this->TakeBase->checkAuth()){
			$this->setRedirect('');
		}

		$this->addLiblary('inoutput/Language');
		$this->Lang = new InoutputLanguage($this->arrayDir['dirProgram'] . 'template/admin/la/', getVar($this->arrayUser, 'la'));

		$this->set('arrayUser', $this->arrayUser);

		//メニュー取得
		$this->addModel(array('master/Menu'));
		$this->set('arrayMenu', $this->MasterMenu->getData()->getDataAll());
	}

}
?>