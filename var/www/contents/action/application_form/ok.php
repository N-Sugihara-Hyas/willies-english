<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName']));
		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];

		if ($this->uid != 'reflash'){
			//認証と設定
			if (!$this->$modelName->setDataSID($this->uid) ){
				$this->setRedirect('login');
			}else{
				$this->setRedirect('login');
			}
		}
		
		$this->setRedirect('login');
?>