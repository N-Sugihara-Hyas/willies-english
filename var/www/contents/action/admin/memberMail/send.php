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

		$this->set('arrayWeek', $this->$modelName->getFunctionData('Schedule'));
		$this->set('arrayCource', $this->$modelName->getFunctionData('CourceBase'));
		$this->set('arrayTake', $this->$modelName->getFunctionData('TakeBase'));
		$this->set('arrayMemberState', $this->$modelName->getFunctionData('MemberState'));

		$this->set('arrayMailTarget', $this->$modelName->getData());

		$this->set('arraySettingAdmin', $arraySetting['base']);

?>