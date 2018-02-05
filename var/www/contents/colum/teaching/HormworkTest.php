<?php
	$arrayColum = array(
		'category' => array(
			'name' => 'カテゴリ',
			'type' => 'radio',
			'list' => '1',
			'data' => 'Teaching',
			'search' => true,
			'default' => 0,
		),
		'teaching_base_id' => array(
			'name' => '教材',
			'type' => 'select',
			'data' => 'TeachingBase',
			'list' => '0',
			'form' => 'style="width:100%;"',
			'search' => true,
		),
		'teaching_lesson_id' => array(
			'name' => 'レッスン',
			'type' => 'select',
			'data' => 'TeachingLesson',
			'list' => '1',
			'form' => 'style="width:100%;"',
			'search' => true,
		),
	);

	$self->parent->updateDataOut = function() use($self){

		
	};

	$self->parent->updateData = function() use($self){

	};

	$self->parent->updateDataAffter = function($uid) use($self){
	};


?>