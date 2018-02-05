<?php

	$arrayColum = array(
		'body' => array(
			'name' => 'Text',
			'type' => 'textarea',
			'list' => '0',
			'form' => 'style="width:70%;height:6em;"',
			'search' => 1,
		),
	);

	$self->parent->updateData = function() use($self){
		$id = $self->getSession('id');
		$self->arrayData['member_base_id'] = $id;
	};
?>