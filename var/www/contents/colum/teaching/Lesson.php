<?php
	$arrayColum = array(
		'category' => array(
			'name' => 'カテゴリ',
			'type' => 'checkbox',
			'list' => '1',
			'data' => 'Teaching',
			'search' => false,
			'default' => 0,
		),
		'teaching_base_id' => array(
			'name' => '教材名',
			'type' => 'select',
			'list' => '1',
			'data' => 'TeachingBase',
			'search' => true,
			'default' => 0,
		),
		'lessonName' => array(
			'name' => 'レッスン名',
			'type' => 'text',
			'list' => '1',
			'search' => true,
			'form' => '',
		),
		'sort' => array(
			'name' => '並び順',
			'type' => 'text',
			'list' => '1',
			'search' => true,
			'default' => 0,
			'form' => '',
		),
	);

	$self->parent->updateDataOut = function() use($self){
		$this->arrayInput['category'] = json_decode($this->arrayInput['category'], true);
		
	};

	$self->parent->updateData = function() use($self){
		$this->arrayData['category'] = json_encode($this->arrayData['category']);
	};


	$self->parent->updateDataAffter = function($uid) use($self){
	};


?>