<?php

	$arrayColum = array(
		'type' => array(
			'name' => '種類',
			'type' => 'select',
			'list' => '1',
			'search' => true,
			'labelBack' => '<span class="attBox">*</span>',
			'data' => 'HomeworkBookType',
		),
		'cource_base_id' => array(
			'name' => 'コース',
			'type' => 'select',
			'list' => '1',
			'search' => true,
			'labelBack' => '<span class="attBox">*</span>',
			'data' => 'CourceBase',
		),
		'level' => array(
			'name' => 'Level',
			'type' => 'select',
			'list' => '1',
			'search' => true,
			'labelBack' => '<span class="attBox">*</span>',
			'data' => 'Level',
		),
		'title' => array(
			'name' => 'タイトル',
			'type' => 'text',
			'list' => '1',
			'search' => true,
			'labelBack' => '<span class="attBox">*</span>',
			'form' => '',
		),
		'comment' => array(
			'name' => 'comment',
			'type' => 'textarea',
			'list' => 0,
			'search' => false,
			'labelBack' => '<span class="attBox">*</span>',
			'form' => 'style="width:90%;"',
		),

	);

	$self->parent->updateDataOut = function() use($self){

	};

	$self->parent->updateData = function() use($self){

	};


?>