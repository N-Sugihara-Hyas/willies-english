<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName'], 'member/Base'));
		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];

		//共通処理
		$this->getCommon();
		
		$this->$modelName->addModelTool('Form');
		$this->$modelName->setColum('ext/ExerciseTake');
		$uid = $this->$modelName->getEditEnd();

		$this->$modelName->addModelTool('Mail');
		$mID = $this->$modelName->getSession('mID');
		
		$this->$modelName->arrayData = $this->MemberBase->getDataUID($mID)->getData();
		$this->$modelName->arrayData['url'] = 'http://' . $this->arraySetting['domain'] . '/mypage/exercise/details/' . $uid;
		
		$this->$modelName->arrayData['domain'] = $arraySetting['domain'];
		$this->$modelName->mailSend(18, array($this->$modelName->arrayData['email']));

		$this->setRedirect($this->arrayAction['dir'] . 'list/' . $uid . '/?e=reflash');
?>