<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		$this->addLiblary(array('mail/QdMail'));

		//共通処理
		$this->getCommon();
		$MailQdMail = new MailQdMail();
		
				
		//$MailQdMail->to(array($this->arrayAll['email']));
		//$MailQdMail->bcc(array('rikitikbaby@gmail.com', 'shigerut0521@gmail.com'));

		$arrayMail = array($this->arrayAll['email'], 'shigerut0521@gmail.com', 'rikitikbaby@gmail.com');
		
		foreach ($arrayMail as $item){
			$MailQdMail->to(array($item));		
			$MailQdMail->subject($this->arrayAll['subject']);
			$MailQdMail->setBody($this->arrayAll['body']);
			$MailQdMail->from($this->arraySetting['from'], $this->arraySetting['title']);
			$MailQdMail->_send();
		}
		
		$this->set('arraySettingAdmin', $arraySetting['base']);

?>