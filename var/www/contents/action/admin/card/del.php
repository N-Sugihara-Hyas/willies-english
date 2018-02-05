<?php

/***********************************************************
*	項目の削除
*/

	//共通処理
	$this->getCommon();

	//モデル情報の読み込み
	require_once 'conf.php';
	$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName'], 'card/Details'));


	$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];


	if (!empty($this->arrayAll['arrayDel'])){
		$this->$modelName->addModelTool('List');
		$this->$modelName->listDelData($this->arrayAll['arrayDel']);
		
		//該当のカード内容も削除
		foreach ($this->arrayAll['arrayDel'] as $item){
			$this->CardDetails->addQuery('id', $item);
			$this->CardDetails->delData($item);
		}
	}else{
		$this->setRedirect($this->arrayAction['dir'] . 'list/?e=errorDel');
	}

	$this->setRedirect($this->arrayAction['dir'] . 'list/?e=reflashDel');

?>