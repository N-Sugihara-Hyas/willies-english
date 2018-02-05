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

			$this->$modelName->arrayUser = $this->arrayUser;

			$this->$modelName->addModelTool('Form');
			$this->$modelName->setColum();
			$uid = $this->$modelName->getEditEnd();
			
			$this->$modelName->arrayUser = $this->arrayUser;


			$this->$modelName->addModelTool('Mail');
			$this->$modelName->arrayMail = $this->arrayUser;
			
			//管理者に送付
			$this->$modelName->arrayMail['domain'] = $this->arraySetting['domain'];
			$this->$modelName->arrayData['created'] = date('Y-m-d');
			$this->$modelName->isFormData = true;
			$this->$modelName->mailSend(21, array($this->$modelName->arraySetting['email4']));

			//管理者のお知らせに追加
			$this->MasterAdminNews->addMailData(21, $this->$modelName->arrayMailSetting['body'], $this->$modelName->arrayMailSetting);

			//ユーザーに送付
			$this->$modelName->arrayMail['domain'] = $this->arraySetting['domain'];
			$this->$modelName->arrayData['created'] = date('Y-m-d');
			$this->$modelName->mailSend(22, array($this->arrayUser['email']));



			//$this->setRedirect($this->arrayAction['dir'] . 'editEnd/end/');
		}
?>