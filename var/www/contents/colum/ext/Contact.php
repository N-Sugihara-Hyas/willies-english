<?php

	$arrayColum = array(
		'name' => array(
			'name' => 'お名前',
			'type' => 'text',
			'list' => '1',
			'labelBack' => '<span class="attBox">(必須)</span>',
			'form' => 'style="width:100%;"',
			'search' => true,
		),
		'category' => array(
			'name' => 'お問合せカテゴリー',
			'type' => 'select',
			'list' => '1',
			'data' => 'ContactType',
			'labelBack' => '<span class="attBox">(必須)</span>',
			'form' => 'style="width:100%;"',
			'search' => true,
		),
		'body' => array(
			'name' => '本文',
			'type' => 'textarea',
			'list' => '0',
			'labelBack' => '<span class="attBox">必須</span>',
			'form' => 'style="width:100%;height:10em;"',
			'search' => false,
		),
	);

	$self->parent->updateDataOut = function() use($self){

	};

	$self->parent->updateData = function() use($self){
		$self->arrayData['member_base_id']  = $self->arrayUser['id'];
	};


?>