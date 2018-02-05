<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName'], 'member/Base', 'ext/Homework'));

		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];

		//共通処理
		$this->getCommon();

		$this->$modelName->delCard($this->arrayAll['cpage']);
		
		header('Location:' . $this->arrayAll['return']);
		exit();
?>