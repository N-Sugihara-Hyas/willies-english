<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName'], 'member/Base', 'master/MailLog', 'member/MailBlock'));
		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];
		$this->addLiblary(array('mail/QdMail'));

		//共通処理
		$this->getCommon();
		$MailQdMail = new MailQdMail();

		//リストの設定
		$arrayMail = $this->$modelName->getDataUID($this->arrayPost['mID'])->getData();
		
		foreach ($this->arrayPost['arrayTarget'] as $key => $item){
			if ($item){
				$this->MemberBase->addQuery($key, $item);
			}
		}

		if (!empty($this->arrayPost['arrayCheck'])){
			$this->MemberBase->addQuery('(0');
			foreach ($this->arrayPost['arrayCheck'] as $key => $item){
				if ($item){
					$this->MemberBase->addQuery('OR member_base.state', $item);
				}
			}
			$this->MemberBase->addQuery('1)');
		}

		$dbMember = $this->MemberBase->getData();
		
		while ($item = $dbMember->getData()){
			$arrayBlock = $this->MemberMailBlock->getMemberType($item['id'], '3_0')->getData();
			
			if (!$arrayBlock){			
				$this->MasterMailLog->addLog($item['email'], $arrayMail['subject'], $arrayMail['body'], $item['id']);
	
				
				$MailQdMail->to(array($item['email']));
				$MailQdMail->subject($arrayMail['subject']);
				$MailQdMail->setBody($arrayMail['body']);
				$MailQdMail->from($this->arraySetting['from'], $this->arraySetting['title']);
				$MailQdMail->_send();
				sleep(1);
			}
		}

		$this->set('arraySettingAdmin', $arraySetting['base']);

?>