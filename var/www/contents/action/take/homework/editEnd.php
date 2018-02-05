<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName']));
		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];

		//共通処理
		$this->getCommon();

		$this->$modelName->addModelTool('Form');
		$this->$modelName->setColum();
		$this->$modelName->arrayUser = $this->arrayUser;
		$uid = $this->$modelName->getEditEnd();


		$this->setRedirect($this->arrayAction['dir'] . 'list/' . $uid . '/?e=reflash');
?>