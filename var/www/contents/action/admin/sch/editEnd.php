<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName'], 'take/Base', 'master/AdminNews'));
		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];

		//共通処理
		$this->getCommon();

		$this->$modelName->addModelTool('Form');
		$this->$modelName->setColum();
		$uid = $this->$modelName->getEditEnd();

		$this->MasterAdminNews->addModelTool('Mail');
		$arrayTakeBase = $this->TakeBase->getDataUID($this->$modelName->arrayData['take_base_id'])->getData();
		$this->MasterAdminNews->arrayData['domain'] = $this->arraySetting['domain'];
		$this->MasterAdminNews->mailSend(23, array($arrayTakeBase['email']));
		
		//講師にもお知らせ追加
		$this->MasterAdminNews->addMailData(23, $this->MasterAdminNews->arrayMailSetting['body'], $this->MasterAdminNews->arrayMailSetting, $arrayTakeBase['id']);

		$redirect = $this->$modelName->getSession('redirect');


		$this->setRedirect(urldecode($redirect));
?>