<?php

	$arrayColum = array(
		'name' => array(
			'name' => '生徒様お名前',
			'type' => 'text',
			'list' => '1',
			'labelBack' => '<span class="attBox">(必須)</span>',
			'form' => 'style="width:100%;"',
			'search' => true,
		),
		'take_base_id' => array(
			'name' => '講師名',
			'type' => 'text',
			'list' => '1',
			'labelBack' => '<span class="attBox">(必須)</span>',
			'form' => 'style="width:100%;"',
			'search' => true,
		),
		'date' => array(
			'name' => 'レッスン受講日',
			'type' => 'text',
			'list' => '1',
			'labelBack' => '<span class="attBox">(必須)</span>',
			'search' => true,
			'form' => '',
		),
		'time' => array(
			'name' => 'レッスン時間帯',
			'type' => 'select',
			'list' => '1',
			'data' => 'Time',
			'labelBack' => '<span class="attBox">(必須)</span>',
			'form' => 'style="width:100%;"',
			'search' => true,
		),
		'star' => array(
			'name' => '講師・レッスン評価',
			'type' => 'select',
			'list' => '1',
			'data' => 'FeedBackType',
			'labelBack' => '<span class="attBox">(必須)</span>',
			'form' => 'style="width:100%;"',
			'search' => true,
		),
		'body' => array(
			'name' => 'フィードバック内容',
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