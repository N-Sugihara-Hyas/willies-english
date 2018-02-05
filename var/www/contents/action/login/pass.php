<?php
/*
*	パスワードを忘れた方画面
*/

		//モデル情報の読み込み
		$this->addModel(array('member/Base'));

		//パスワードを忘れた方
		$this->MemberBase->addModelTool('MailRemind');


		if ($this->arrayPost){
			if ($this->MemberBase->remindSendMail(25, $this->arrayAll['email'])){
				$this->setShow('passEnd');
			}
		}
		
		$this->set('email', getVar($this->arrayAll, 'email'));



?>