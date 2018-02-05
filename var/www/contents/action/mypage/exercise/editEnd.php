<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName'], 'master/AdminNews'));
		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];

		//共通処理
		$this->getCommon();

		if (!$this->uid){
			//if (!$this->isTake()){$this->setRedirect('errors');}

			$this->$modelName->arrayUser = $this->arrayUser;

			
			$this->$modelName->addModelTool('Form');
			$this->$modelName->setColum();
			$uid = $this->$modelName->getEditEnd();

			$this->$modelName->arrayData['id'] = $uid;
			$this->MasterAdminNews->sendMailFeedBack($this->arrayUser, $this->$modelName->arrayData);

			$this->setRedirect($this->arrayAction['dir'] . 'editEnd/end/');
		}
?>