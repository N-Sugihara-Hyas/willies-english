<?php
/*
*	新規メンバー登録の確認画面
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName']));
		$this->addValidate(array($arraySetting['base']['validateDir'] . '/' . $arraySetting['base']['validateName']));

		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];
		$validateName = 'Validate' . ucwords($arraySetting['base']['validateDir']) . $arraySetting['base']['validateName'];

		//共通処理
		$this->$modelName->addModelTool('Form');
		$this->$modelName->setColum();

		$this->$validateName->$modelName = &$this->$modelName;

		$this->set('mode', $this->$modelName->getUID());
		$this->set('modelName', $modelName);
		$this->set('arrayError', $this->$validateName->arrayError);
		$this->set('arraySettingAdmin', $arraySetting['base']);
		$this->set('uid', $this->$modelName->getUID());


		if ($this->$validateName->checkData($this->arrayPost['arrayInput'][$modelName]) ){

			$this->set('arrayError', $this->$validateName->arrayError);
			$this->set('arrayColum', $this->$modelName->arrayColum);
			$this->set('arrayInput', $this->arrayPost['arrayInput'][$modelName]);

			$this->setShow('index');
		}else{
			$this->$modelName->getEditConfirmation($this->arrayPost['arrayInput'][$modelName]);

			$this->set('arrayInput', $this->arrayPost['arrayInput'][$modelName]);

			$this->set('arrayColum', $this->$modelName->arrayColum);
		}


?>