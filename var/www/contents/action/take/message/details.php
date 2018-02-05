<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName'], 'take/MessageOpen'));

		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];

		//共通処理
		$this->getCommon();

		$this->$modelName->addModelTool('Form');
		$this->$modelName->setColum();
		
		$this->$modelName->addQuery('(1');		
		$this->$modelName->addQuery('to_id', $this->arrayUser['id']);
		$this->$modelName->addQuery('OR to_id', 0);
		$this->$modelName->addQuery('1)');		

		$this->TakeMessageOpen->setOpen($this->uid, $this->arrayUser['id']);

		$mode = $this->$modelName->getEdit($this->uid);

		$this->set('uid', $this->$modelName->getUID());
		$this->set('e', getVar($this->arrayAll, 'e'));
		$this->set('arrayColum', $this->$modelName->arrayColum);
		$this->set('reflash', getVar($this->arrayAll, 'reflash'));
		$this->set('modelName', $modelName);
		$this->set('arrayInput', $this->$modelName->arrayInput);
		$this->set('arraySettingAdmin', $arraySetting['base']);

?>