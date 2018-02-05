<?php

	$arrayColum = array(
		'companyName' => array(
			'name' => 'グループ名',
			'type' => 'text',
			'list' => '1',
			'search' => true,
			'labelBack' => '<span class="attBox">*</span>',
			'form' => '',
		),
		'loginID' => array(
			'name' => '閲覧用ID',
			'type' => 'text',
			'list' => '1',
			'search' => true,
			'labelBack' => '<span class="attBox">*</span>',
			'form' => '',
		),
		'pass' => array(
			'name' => '閲覧用パスワード',
			'type' => 'text',
			'list' => '1',
			'search' => false,
			'labelBack' => '<span class="attBox">*</span>',
			'form' => '',
		),
		'arrayMember' => array(
			'name' => '生徒ID',
			'type' => 'text',
			'list' => '0',
			'search' => true,
			'labelBack' => '',
			'form' => '',
		),
	);

	$self->parent->updateDataOut = function() use($self){
		$self->arrayInput['arrayMember'] = '';
			
		if (!empty($self->arrayInput['id'])){
			$CompanyMember = $self->getModel('company/Member');
			
			$CompanyMember->addQuery('company_base_id', $self->arrayInput['id']);
			$dbGet = $CompanyMember->getData();
		
			while ($objData = $dbGet->getData()){
				$self->arrayInput['arrayMember'].=$objData['member_base_id'] . ',';		
			}	
			
			if ($self->arrayInput['arrayMember']){
				$self->arrayInput['arrayMember'] = substr($self->arrayInput['arrayMember'], 0, strlen($self->arrayInput['arrayMember']) - 1);
			}
		}

		$self->addLiblary('securty/Code');
		
		$SecurtyCode = new SecurtyCode($self->arraySetting['secretKey']);
		$self->arrayInput['pass'] = $SecurtyCode->getDecode($self->arrayInput['pass']);
	};
	
	$self->parent->updateData = function() use($self){
		$self->arrayMember = explode(',', $self->arrayData['arrayMember']);
		unset($self->arrayData['arrayMember']);
		
		$self->addLiblary('securty/Code');
		
		$SecurtyCode = new SecurtyCode($self->arraySetting['secretKey']);
		$self->arrayData['pass'] = $SecurtyCode->getEncode($self->arrayData['pass']);
	};

	$self->parent->updateDataAffter = function($uid) use($self){
		$CompanyMember = $self->getModel('company/Member');
		
		$CompanyMember->addQuery('company_base_id', $uid);
		$CompanyMember->delData();
		
		foreach ($self->arrayMember as $member){
			$objData['member_base_id'] = $member;
			$objData['company_base_id'] = $uid;

			$CompanyMember->commit($objData);
		}
	};
?>