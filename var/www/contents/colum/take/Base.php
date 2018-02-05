<?php
	$self->modelImage = 'media/Image';

	$arrayColum = array(
		'takeName' => array(
			'name' => 'Teacher\'s Name',
			'type' => 'text',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => '',
			'search' => true,
		),
		'address' => array(
			'name' => 'Address',
			'type' => 'text',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => '',
			'search' => true,
		),
		'nickname' => array(
			'name' => 'Nickname',
			'type' => 'text',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => '',
			'search' => true,
		),
		'photo' => array(
			'name' => 'Photo',
			'type' => 'file',
			'list' => '0',
			'api'	=> '/api/imgMedia/',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => '',
			'search' => false,
		),
		'email' => array(
			'name' => 'E-mail',
			'type' => 'text',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => '',
			'search' => true,
		),
		'skypeID' => array(
			'name' => 'Skype ID',
			'type' => 'text',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => '',
			'search' => true,
		),
		'tel' => array(
			'name' => 'Tel',
			'type' => 'text',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => '',
			'search' => true,
		),
		'loginID' => array(
			'name' => 'Login ID',
			'type' => 'text',
			'list' => '0',
			'form' => '',
			'search' => true,
		),
		'pass' => array(
			'name' => 'pass',
			'type' => 'text',
			'list' => '0',
			'form' => '',
			'search' => false,
		),
		'comment' => array(
			'name' => 'PR',
			'type' => 'textarea',
			'list' => '1',
			'form' => 'style="width:100%; height10em;"',
			'search' => true,
		),
		'arrayTakeCource' => array(
			'name' => 'Cource',
			'type' => 'checkbox',
			'data' => 'CourceBase',
			'list' => '0',
			'form' => '',
			'li' => '<br class="fc" />',
			'search' => false,
		),
		'arrayTakeCourceDaily' => array(
			'name' => 'Cource(Daily)',
			'type' => 'checkbox',
			'data' => 'CourceBaseDaily',
			'list' => '0',
			'form' => '',
			'li' => '<br class="fc" />',
			'search' => false,
		),
		'isView' => array(
			'name' => 'MasterSchedule',
			'type' => 'checkbox',
			'checkValue' => 'view',
			'list' => false,
			'search' => false,
		),

	);

	$self->parent->updateDataOut = function() use($self){
		$SettingMeta = getModel('setting/Meta');

		$self->arrayInput['arrayTakeCource'] = $SettingMeta->getMeta('arrayTakeCource_' . $self->arrayInput['id']);
		$self->arrayInput['arrayTakeCourceDaily'] = $SettingMeta->getMeta('arrayTakeCourceDaily_' . $self->arrayInput['id']);

		$self->addLiblary('securty/Code');
		
		$SecurtyCode = new SecurtyCode($self->arraySetting['secretKey']);
		$self->arrayInput['pass'] = $SecurtyCode->getDecode($self->arrayInput['pass']);
	};

	$self->parent->updateData = function() use($self){
		$self->arrayTakeCource = $self->arrayData['arrayTakeCource'];
		unset($self->arrayData['arrayTakeCource']);
		$self->arrayTakeCourceDaily = $self->arrayData['arrayTakeCourceDaily'];
		unset($self->arrayData['arrayTakeCourceDaily']);


		$self->addLiblary('securty/Code');
		
		$SecurtyCode = new SecurtyCode($self->arraySetting['secretKey']);
		$self->arrayData['pass'] = $SecurtyCode->getEncode($self->arrayData['pass']);

		if (empty($self->arrayData['isView'])){
			$self->arrayData['isView'] = 0;
		}
	};

	$self->parent->updateDataAffter = function($uid) use($self){
		$SettingMeta = getModel('setting/Meta');
		$SettingMeta->setMetaArray('arrayTakeCource_' . $uid, $self->arrayTakeCource);
		$SettingMeta->setMetaArray('arrayTakeCourceDaily_' . $uid, $self->arrayTakeCourceDaily);

	};


?>