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

		$this->$modelName->addModelTool('Mail');

		$this->$modelName->addModelTool('Form');
		$this->$modelName->setColum();
		$this->$modelName->arrayUser = $this->arrayUser;
		$uid = $this->$modelName->getEditEnd();

		if ($this->$modelName->getSession('save')){
			$arrayMember = $this->MemberBase->getDataUID($this->$modelName->getSession('mID'))->getData();
			$this->$modelName->arrayMail = $this->$modelName->arrayData;
			$this->$modelName->arrayMail = array_merge($this->$modelName->arrayMail, $arrayMember);
			$this->$modelName->arrayMail = array_merge($this->$modelName->arrayMail, $this->arrayUser);

			$this->$modelName->mailSend(42, array($arrayMember['email']));
		}

		$this->setRedirect($this->arrayAction['dir'] . 'list/' . $uid . '/?e=reflash');
?>