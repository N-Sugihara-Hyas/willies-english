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

		if (!$this->uid){
			$this->$modelName->arrayUser = $this->arrayUser;

			$this->$modelName->addModelTool('Form');
			$this->$modelName->setColum('member/BaseUser');
			$uid = $this->$modelName->getEditEnd();

			$this->setRedirect($this->arrayAction['dir'] . 'editEnd/end/');
		}
?>