<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName'], 'card/Base'));
		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];

		//共通処理
		$this->getCommon();

		if (!$this->uid){

			$this->$modelName->arrayUser = $this->arrayUser;

			$this->$modelName->addModelTool('Form');
			$this->$modelName->setColum();
			$this->$modelName->arrayUser = $this->arrayUser;

			$arrayData = $this->$modelName->getFormData();
			$this->CardBase->addQuery('id', $arrayData['card_base_id']);
			$arrayCardBase = $this->CardBase->getData()->getData();

			if ($arrayCardBase['member_base_id'] != $this->arrayUser['id']){
				$this->setRedirect('');
			}

			$this->$modelName->createCard($arrayCardBase['id'], 0, 2);


			$this->setRedirect($this->arrayAction['dir'] . 'editEnd/' . $arrayCardBase['id'] . '/');
		}
?>