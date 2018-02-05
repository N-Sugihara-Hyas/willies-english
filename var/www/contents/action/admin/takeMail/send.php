<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName'], 'take/Base'));
		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];

		//共通処理
		$this->getCommon();



		//テンプレートでの送信もありにする
		$arrayMailMember = $this->$modelName->getData()->getDataAll();
		$this->set('arrayMailMember', $arrayMailMember);

		$this->set('arrayTarget', $this->TakeBase->getData());
		$this->set('arrayMailTarget', $this->$modelName->getData());

		$this->set('arraySettingAdmin', $arraySetting['base']);

?>