<?php
/*
*	講師の情報詳細
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array('take/Base', $arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName']));
		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];

		//共通処理
		$this->getCommon();
		$this->TakeBase->mode = 1;
		
		$this->set('arrayCourceBase', $this->$modelName->getDataUID($this->uid)->getData());
		$this->set('arrayTakeBase', $this->TakeBase->getDataCource($this->uid));


?>