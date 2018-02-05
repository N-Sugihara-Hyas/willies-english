<?php
/*
*	トピックスリストの読み込み
*/

		$this->addLiblary(array('mail/QdMail'));

		//共通処理
		$this->getCommon();
		$MailQdMail = new MailQdMail();

		
			
		$MailQdMail->to(array($this->arrayAll['email']));
		$MailQdMail->subject('本登録');
		$MailQdMail->setBody(urldecode($this->arrayAll['body']));
		$MailQdMail->from('info@williesenglish.jp', 'レゴリス');
		$MailQdMail->_send();

?>