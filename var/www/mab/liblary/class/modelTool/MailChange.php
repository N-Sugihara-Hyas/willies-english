<?php
	require_once 'Mail.php';

	$self->sid = 'sid';
	$self->id = 'id';
	$self->emailNew = 'emailNew';
	$self->email = 'email';
	
	$self->parent->checkMailID = function($id) use($self){
		if (!$id){
			return false;
		}
				
		$self->addQuery($self->id, $id);

		return $self->getData()->getData();
	};
	
	$self->parent->addMailSID = function($id, $email) use($self){		
		if (!$email){return $email;}
				
		if (!$arrayUser = $self->checkMailID($id)){
			return false;
		}
		
				
		$self->addLiblary('inoutput/String');
		$arrayUser[$self->sid] = InoutputString::getRandomString(32);
		$arrayUser[$self->emailNew] = $email;
		
		$self->commit($arrayUser);
		
		$self->arrayUser = $arrayUser;
		
		return $arrayUser;
	};
	
	$self->parent->mailSendSID = function($mID, $url, $arrayCC=array(), $arrayBCC=array()) use ($self){		
		$self->arrayMail['url'] = 'http://' . $self->arraySetting['domain'] . '/' . $url . '?sid=' . $self->arrayUser['sid'];
		$self->mailSend($mID, array($self->arrayUser['email']), $arrayCC, $arrayBCC);
	};

	$self->parent->checkMailSID = function($sid) use($self){
		if (!$sid){return false;}

		$self->addQuery($self->sid, $sid);

		return $self->getData();
	};
	
	$self->parent->changeMailSID = function($sid) use($self){
		if (!$arrayUser = $self->checkMailSID($sid)->getData()){
			return false;
		}
		$arrayUser[$self->email] = $arrayUser[$self->emailNew];
		$arrayUser[$self->sid] = '';
		
		$self->commit($arrayUser);
		
		return true;
	}

?>