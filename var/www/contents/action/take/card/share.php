<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName'], 'member/Base'));
		$this->addValidate(array($arraySetting['base']['validateDir'] . '/' . $arraySetting['base']['validateName']));

		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];
		$validateName = 'Validate' . ucwords($arraySetting['base']['validateDir']) . $arraySetting['base']['validateName'];


		//共通処理
		$this->getCommon();
		$this->$modelName->addModelTool('Form');
		
		$arrayFormData = $this->$modelName->getFormData();
		

		if ((!$arrayFormData['gcc']) && (!$arrayFormData['rlc']) && (!$arrayFormData['followup'])){
			$this->set('isHomeNon', true);
		}
		
		$mID = $this->$modelName->getSession('mID');
		$this->MemberBase->joinCourceBase();
		$this->set('arrayMember', $this->MemberBase->getDataUID($mID)->getData());

		$this->set('my', $_SERVER['REQUEST_URI']);
		$this->set('uid', $this->$modelName->getUID());
		$this->set('arraySettingAdmin', $arraySetting['base']);
		$this->set('arrayCard', $this->$modelName->getCardAll());

?>