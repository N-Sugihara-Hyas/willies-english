<?php
	$arrayColum = array(
		'modified' => array(
			'name' => 'Date',
			'type' => 'text',
			'list' => '1',
			'form' => '',
		),
		'cource_base_id' => array(
			'name' => 'Category',
			'type' => 'radio',
			'list' => '1',
			'data' => 'CourceBaseAll',
			'search' => true,
			'default' => 0,
		),
		'feeType' => array(
			'name' => 'Fee',
			'type' => 'radio',
			'list' => '1',
			'data' => 'Fee',
			'search' => true,
			'default' => 1,
		),
		'fee' => array(
			'type' => 'text',
			'list' => '1',
			'form' => 'style="width:6em;"',
			'controlBack' => '円（税別）',
			'search' => true,
		),
		'card_base_id' => array(
			'name' => 'Card Title',
			'type' => 'select',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'controlBackFirst' => '<a href="javascript:newBase()">新規単語帳作成</a>',
			'data' => 'CardBaseAdmin',
			'form' => '',
			'search' => true,
		),
		'free' => array(
			'name' => 'Free Comment',
			'type' => 'textarea',
			'list' => '1',
			'form' => 'class="textarea" style="width:100%;height:8em;"',
			'search' => true,
		),
		'body1' => array(
			'name' => 'Card (face)<br /><br />Insert Questions such as<br />-GCC/ RLC Japanese<br />-Free Questions you had in a class.<br />(How do you explain XXX?)<br />(Summarize the article XXX.)',
			'type' => 'textarea',
			'list' => '1',
			'form' => 'style="width:100%; height:10em;"',
			'search' => true,
		),
		'body2' => array(
			'name' => 'Card (bottom)<br /><br/ >Insert Answers such as<br />GCC/ RLC English<br />Answers for free questions<br />(XXX is the person who …..)<br />(The article XXX is …..)',
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