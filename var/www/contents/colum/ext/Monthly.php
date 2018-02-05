<?php

	$arrayColum = array(
		'gcc' => array(
			'name' => 'GCC Cycle',
			'type' => 'text',
			'list' => 0,
			'search' => false,
			'form' => 'style="width:100%;"',
		),
		'rlc' => array(
			'name' => 'RLC Cycle',
			'type' => 'text',
			'list' => 0,
			'search' => false,
			'form' => 'style="width:100%;"',
		),
		'feedback' => array(
			'name' => 'Feedback',
			'type' => 'textarea',
			'list' => 0,
			'search' => false,
			'form' => 'style="width:100%;height:25em;"',
		),
	);

	$self->parent->updateDataOut = function() use($self){

	};

	$self->parent->updateData = function() use($self){
		$self->arrayData['member_base_id'] = $self->getSession('mID');
		$self->arrayData['take_base_id'] = $self->arrayUser['id'];

		$self->arrayData['isView'] = $self->getSession('save');
	};


?>