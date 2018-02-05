<?php
	$arrayColum = array(
		'category' => array(
			'name' => 'カテゴリ',
			'type' => 'checkbox',
			'list' => '1',
			'data' => 'Teaching',
			'search' => true,
			'default' => 0,
		),
		'teachingName' => array(
			'name' => '教材名',
			'type' => 'text',
			'list' => '1',
			'form' => 'style="width:100%;"',
			'search' => true,
		),
		'sort' => array(
			'name' => '表示順',
			'type' => 'text',
			'list' => '0',
			'form' => '',
			'search' => false,
			'default' => 0,
		),
	);

	$self->parent->updateDataOut = function() use($self){
		$self->arrayInput['category'] = json_decode($self->arrayInput['category'], true);
		
	};

	$self->parent->updateData = function() use($self){
		$self->arrayData['category'] = json_encode($self->arrayData['category']);
	};

	$self->parent->updateDataAffter = function($uid) use($self){
	};


?>