<?php

	$arrayColum = array(
		'gcc' => array(
			'name' => 'GCC',
			'type' => 'text',
			'list' => 0,
			'search' => false,
			'form' => 'style="width:100%;"',
		),
		'rlc' => array(
			'name' => 'RLC',
			'type' => 'text',
			'list' => 0,
			'search' => false,
			'form' => 'style="width:100%;"',
		),
		'followup' => array(
			'name' => 'Follow up<br />questions',
			'type' => 'textarea',
			'list' => 0,
			'search' => false,
			'form' => 'style="width:100%;height:5em;"',
		),
		'free' => array(
			'name' => 'Free Text',
			'type' => 'textarea',
			'list' => 0,
			'search' => false,
			'form' => 'style="width:100%;height:5em;"',
		),

	);

	$self->parent->updateDataOut = function() use($self){

	};

	$self->parent->updateData = function() use($self){
		$self->arrayData['member_base_id'] = $self->getSession('mID');
		$self->arrayData['take_base_id'] = $self->arrayUser['id'];
	};


?>