<?php

	$arrayColum = array(
		'created' => array(
			'name' => '日時',
			'type' => 'text',
			'list' => '1',
			'search' => false,
			'labelBack' => '<span class="attBox">*</span>',
			'form' => '',
		),
		'member_base_id' => array(
			'name' => '会員ID',
			'type' => 'text',
			'list' => '1',
			'search' => true,
			'labelBack' => '<span class="attBox">*</span>',
			'form' => '',
		),
		'point' => array(
			'name' => 'ポイント',
			'type' => 'text',
			'list' => '1',
			'search' => false,
			'labelBack' => '<span class="attBox">*</span>',
			'form' => '',
		),
		'action' => array(
			'name' => '取得・使用場所',
			'type' => 'select',
			'list' => '1',
			'data' => 'PointHistory',
			'search' => false,
			'labelBack' => '<span class="attBox">*</span>',
			'form' => '',
		),
	);
	
	$self->parent->updateData = function() use($self){
	};


?>