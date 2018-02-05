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
		$arrayCard = $this->$modelName->getFormData();
		$arrayCard['state'] = $this->$modelName->getSession('sub3');
		$arrayCard['admin_login_id'] = $this->arrayUser['id'];
		
		$type = $this->$modelName->getSession('type');

		if (($type == 1) || ($type == 2) ){
			$this->$modelName->createCard($arrayCard['cardName'], 0, 0);
		}else{
			$this->$modelName->createCard($arrayCard['cardName'], 0, 3, 0, $arrayCard);
		}
		
		$this->setRedirect('card/list/?e=reflash');
?>