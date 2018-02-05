<?php

/***********************************************************
*	項目の削除
*/

	//共通処理
	$this->getCommon();

	//モデル情報の読み込み
	require_once 'conf.php';
	$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName'], 'take/Reserve'));


	$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];

	$this->TakeReserve->addQuery('concat(date," ",timeStart) >=', date('Y-m-d H:i:s'));
	$this->TakeReserve->addQuery('member_base_id', $this->uid);
	$this->TakeReserve->delData();

	$arrayData = $this->$modelName->getDataUID($this->uid)->getData();
	$this->$modelName->setDropOut($arrayData);

	$this->setRedirect($this->arrayAction['dir'] . 'list/?e=reflashDel');

?>