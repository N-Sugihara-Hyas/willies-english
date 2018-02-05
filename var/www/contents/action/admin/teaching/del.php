<?php

/***********************************************************
*	項目の削除
*/

	//共通処理
	$this->getCommon();

	//モデル情報の読み込み
	require_once 'conf.php';
	$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName'], 'teaching/Lesson'));


	$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];


	if (!empty($this->arrayAll['arrayDel'])){
		$this->$modelName->addModelTool('List');
		
		/*foreach ($this->arrayAll['arrayDel'] as $del){
			echo $del;
		}
		exit();*/
		
		$this->$modelName->listDelData($this->arrayAll['arrayDel']);
	}else{
		$this->setRedirect($this->arrayAction['dir'] . 'list/?e=errorDel');
	}

	$this->setRedirect($this->arrayAction['dir'] . 'list/?e=reflashDel');

?>