<?php
/*
*	トピックスリストの読み込み
*/

		//ライブラリ情報の読み込み
		$this->addLiblary(array('mail/QdMail'));
		$this->addModel(array('mail/Member', 'master/MailLog', 'member/Base'));
		
		//共通処理
		$this->getCommon();
		
		$MailQdMail = new MailQdMail();

		if ($this->arrayPost){
			
			$subject = $this->arrayPost['subject'];
			$body = $this->arrayPost['body'];

			
			$this->MemberBase->addQuery('email', $this->arrayPost['email']);
			$arrayUser = $this->MemberBase->getData()->getData();
			
			$this->MasterMailLog->addLog($this->arrayPost['email'], $this->arrayPost['subject'], $this->arrayPost['body'], $arrayUser['id']);

			$MailQdMail->to(array($this->arrayPost['email']));
			$MailQdMail->subject($subject);
			$MailQdMail->setBody($body);
			$MailQdMail->from($this->arraySetting['from'], $this->arraySetting['title']);
			$MailQdMail->_send();

			$this->set('isSend', true);
		}
		
		//テンプレートでの送信もありにする
		$arrayMailMember = $this->MailMember->getData()->getDataAll();
		
		$this->set('arrayMailMember', $arrayMailMember);
		$this->set('email', $this->uid);
?>