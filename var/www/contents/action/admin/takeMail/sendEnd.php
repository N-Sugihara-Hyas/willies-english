<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName'], 'take/Base', 'master/MailLog'));
		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];
		$this->addLiblary(array('mail/QdMail'));

		//共通処理
		$this->getCommon();
		$MailQdMail = new MailQdMail();
		
		if (isset($this->arrayPost['arrayTarget'])){
			foreach ($this->arrayPost['arrayTarget'] as $item){

				$arrayTarget = $this->TakeBase->getDataUID($item)->getData();
				$this->MasterMailLog->addLog($arrayTarget['email'], $this->arrayPost['subject'], $this->arrayPost['body'], 0, $arrayTarget['id']);
				
				$MailQdMail->to(array($arrayTarget['email']));
				$MailQdMail->subject($this->arrayPost['subject']);
				$MailQdMail->setBody($this->arrayPost['body']);
				$MailQdMail->from($this->arraySetting['from'], $this->arraySetting['title']);
				$MailQdMail->_send();
			}
		}
		
		$this->set('arraySettingAdmin', $arraySetting['base']);

?>