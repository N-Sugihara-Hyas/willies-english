<?php
	require_once 'Mail.php';

	$self->sid = 'sid';
	$self->email = 'email';
	
	$self->parent->checkMailEmail = function($email) use($self){
		if (!$email){
			return false;
		}
				
		$self->addQuery($self->email, $email);

		return $self->getData()->getData();
	};
	
	$self->parent->remindSendMail = function($mID, $email) use($self){
		if (!$arrayUser = $self->checkMailEmail($email)){
			return false;
		}
		
		$self->addLiblary('securty/Code');

		$SecurtyCode = new SecurtyCode($self->arraySetting['secretKey']);

		$self->arrayMail['pass'] = $SecurtyCode->getDecode($arrayUser['pass']);
		$self->mailSend($mID, array($arrayUser['email']));
		
		return true;
	};

?>