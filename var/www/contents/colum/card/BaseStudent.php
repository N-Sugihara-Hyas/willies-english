<?php
	$arrayColum = array(
		'card_base_id' => array(
			'name' => '単語帳 Title',
			'type' => 'select',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'controlBackFirst' => '<a href="javascript:newBase()">新規単語帳作成</a>',
			'data' => 'CardBase',
			'form' => '',
			'search' => true,
		),
		'body1' => array(
			'name' => 'Card (表)',
			'type' => 'textarea',
			'list' => '1',
			'form' => 'style="width:100%; height:10em;"',
			'search' => true,
		),
		'body2' => array(
			'name' => 'Card (裏)',
			'type' => 'textarea',
			'list' => '1',
			'form' => 'style="width:100%; height:10em;"',
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