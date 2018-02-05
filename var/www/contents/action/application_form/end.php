<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName'], 'master/AdminNews'));
		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];

		//追加処理
		if (!$this->uid){
			$this->$modelName->setColum();
			$this->$modelName->addModelTool('Form');
			$uid = $this->$modelName->getEditEnd();

			
			$this->$modelName->addModelTool('Mail');
			$this->$modelName->arrayMail['domain'] = $this->arraySetting['domain'];
			$this->$modelName->arrayData['created'] = date('Y-m-d');


			$this->$modelName->mailSend(1, array($this->$modelName->arrayData['email']));

			//メール用に少し改造
			$this->$modelName->arrayData['zip1'] = $this->$modelName->arrayData['zip'];
			$this->$modelName->arrayData['tel1'] = $this->$modelName->arrayData['tel'];


			
			$this->$modelName->isFormData = true;
			$this->$modelName->arrayMail['domain'] = $this->arraySetting['domain'];
			$this->$modelName->mailSend(4, array($this->arraySetting['email']));

			$this->MasterAdminNews->addMailData(4, $this->$modelName->arrayMailSetting['body'], $this->$modelName->arrayMailSetting);

			
			$this->setRedirect('application_form/end/reflash');
		}

?>