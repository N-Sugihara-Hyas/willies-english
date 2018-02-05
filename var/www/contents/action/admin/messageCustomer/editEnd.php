<?php
/*
*	トピックスリストの読み込み
*/
	$this->addLiblary(array('mail/QdMail'));

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName'], 'member/Base', 'master/MailLog'));
		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];

		//共通処理
		$this->getCommon();

		if (!$this->uid){
			$this->$modelName->arrayUser = $this->arrayUser;
			$this->$modelName->addModelTool('Form');
			$this->$modelName->setColum();

			$arrayData = $this->$modelName->getFormData();
			$arrayMember = $this->MemberBase->getDataUID($arrayData['member_base_id'])->getData();

			$MailQdMail = new MailQdMail();

			$MailQdMail->to(array($arrayMember['email']));
			$MailQdMail->subject($arrayData['subject']);
			$MailQdMail->setBodyHtml($arrayData['message']);
			$MailQdMail->from($this->arraySetting['from'], $this->arraySetting['title']);
			$MailQdMail->_send();

			$this->MasterMailLog->addLog($arrayMember['email'], $arrayData['subject'], $arrayData['message'], $arrayData['member_base_id']);

			$this->setRedirect($this->arrayAction['dir'] . 'editEnd/reflash/?e=reflash');
		}
?>