<?php
	require_once dirname(__FILE__) . '/../mail/QdMail.php';
	$self->isSmtp = true;
	$self->isFormData = false;
	$self->arrayMail = array();
	
		/*
		 * メールの送信
		 * @paramse $mID メールのテンプレートのIDを指定 $arrayTo メール送信先
		 */
	$self->parent->mailSend = function($mID, $arrayTo, $arrayCC=array(), $arrayBCC=array()) use ($self){
		$AdminMail = $self->getModel('admin/Mail');

		//指定データの取得
		$self->arrayMailSetting = $AdminMail->getDataUID($mID)->getData();


		//メールデータの整形を行う場合は処理
		if ($self->isFormData){
			$self->arrayMail['bodyContents'] = '';

			foreach ($self->arrayColum as $key => $item){
				if (isset($self->arrayData[$key]) ){
					if ((getVar($self->arrayColum[$key], 'type') != 'password') && (getVar($self->arrayColum[$key], 'type') != 'html')){

						if (isset($self->arrayColum[$key])){
							//本文用に作る
							if (isset($self->arrayColum[$key]['name']) ){
								$self->arrayMail['bodyContents'].= '■' . $self->arrayColum[$key]['name'] . "\n";
							}
							
							if (isset($self->arrayColum[$key]['data']) ){
								$self->arrayData[$key] = $self->getFunctionDataOwn($self->arrayColum[$key]['data'], $self->arrayData[$key]);
							}
							
							$self->arrayMail['bodyContents'].= $self->arrayData[$key] . "\n";
						}
					}
				}
			}
		}

	
		if (!isset($self->arrayData)){$self->arrayData = array();}
		
		$arrayMail = array_merge($self->arraySetting, $self->arrayMail);		
		$arrayMail = array_merge($arrayMail, $self->arrayData);
		

		//メール送信
		$MailQdMail = new MailQdMail(null, $self->isSmtp);
		
		/*$self->arrayMailSetting['subject'] = 'こんにちは';
		$self->arrayMailSetting['body'] = 'こんにちは';
		*/	
			
		$self->arrayMailSetting['body'] = $MailQdMail->setBody($self->arrayMailSetting['body'], $arrayMail);

		

		$self->arrayMailSetting['subject'] = $MailQdMail->changeVar($self->arrayMailSetting['subject'], $arrayMail);
		$self->arrayMailSetting['fromTitle'] = $MailQdMail->changeVar($self->arrayMailSetting['fromTitle'], $arrayMail);
		$self->arrayMailSetting['from'] = $MailQdMail->changeVar($self->arrayMailSetting['from'], $arrayMail);

		$MailQdMail->mtaOption( "-f " . $self->arrayMailSetting['from']);
		
		$MailQdMail->to( $arrayTo );
		$MailQdMail->subject(  $self->arrayMailSetting['subject']);
		$MailQdMail->from( $self->arrayMailSetting['from'] ,  $self->arrayMailSetting['fromTitle']);
		$MailQdMail->_send();

	};
?>