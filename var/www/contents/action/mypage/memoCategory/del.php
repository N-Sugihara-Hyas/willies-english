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

		$this->$modelName->addQuery('id', $this->arrayAll['cID']);
		$this->$modelName->addQuery('member_base_id', $this->arrayUser['id']);
		$this->$modelName->delData();
		
		$this->setRedirect('mypage/memo/list/');
?>