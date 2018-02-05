<?php
/*
*	講師の情報詳細
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName']));
		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];

		//共通処理
		$this->getCommon();

		$this->$modelName->addModelTool('Colum');
		$this->$modelName->setColum();

		$arrayInput = $this->$modelName->getDataUID($this->uid)->getData();
		$this->$modelName->arrayInput = $arrayInput;
		$this->$modelName->updateDataOut();

		$this->set('arrayColum', $this->$modelName->arrayColum);
		$this->set('modelName', $modelName);
		$this->set('arrayInput', $this->$modelName->arrayInput);
		$this->set('arraySettingAdmin', $arraySetting['base']);


?>