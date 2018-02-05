<?php

	$arrayColum = array(
		'english' => array(
			'name' => 'Student String',
			'type' => 'string',
			'list' => '1',
			'form' => '',
			'search' => true,
		),
		'takeComment' => array(
			'name' => 'Teacher’s advice',
			'type' => 'textarea',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => 'style="width:100%;height:10em;"',
			'search' => false,
		),

	);

	$self->parent->updateDataOut = function() use($self){
	};

	$self->parent->updateData = function() use($self){		
		$arrayExe = $self->getDataUID($self->getUID())->getData();

		$ExtMaster = $self->getModel('master/Communication');
		$ExtMaster->addDataType($arrayExe['member_base_id'], $arrayExe['id'], 'comm');


		$self->arrayData['isTake'] = 1;
	};



?>