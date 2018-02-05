<?php
	$arrayColum = array(
		'typeName' => array(
			'name' => 'Type',
			'type' => 'text',
			'list' => 1,
			'search' => true,
			'form' => '',
		),
		'cource_base_id' => array(
			'name' => 'Category',
			'type' => 'radio',
			'list' => '0',
			'data' => 'CourceBaseAll',
			'search' => true,
			'default' => 0,
		),
	);

	$self->parent->updateDataOut = function() use($self){
	};

	$self->parent->updateData = function() use($self){

	};

	$self->parent->updateDataAffter = function($uid) use($self){
	};


?>