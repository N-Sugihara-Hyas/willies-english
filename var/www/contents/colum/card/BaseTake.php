<?php
	$arrayColum = array(
		'modified' => array(
			'name' => 'Date',
			'type' => 'text',
			'list' => '1',
			'form' => '',
		),
		'html' => array(
			'name' => '■ Homework',
			'type' => 'html',
			'list' => 0,
			'search' => false,
			'html' => '<br /><br />',
		),
		'gcc' => array(
			'name' => 'GCC',
			'type' => 'text',
			'list' => 0,
			'search' => false,
			'form' => 'style="width:100%;"',
		),
		'rlc' => array(
			'name' => 'RLC',
			'type' => 'text',
			'list' => 0,
			'search' => false,
			'form' => 'style="width:100%;"',
		),
		'followup' => array(
			'name' => 'Follow up<br />questions',
			'type' => 'textarea',
			'list' => 0,
			'search' => false,
			'form' => 'style="width:100%;height:5em;"',
		),
		'html2' => array(
			'name' => '■ Feedback and Flash Card',
			'type' => 'html',
			'list' => 0,
			'search' => false,
			'html' => '<br /><br />',
		),
		'temp' => array(
			'name' => 'Select Template',
			'type' => 'select',
			'list' => '1',
			'data' => 'CardReview',
			'search' => true,
		),
		'level' => array(
			'name' => 'Level',
			'type' => 'text',
			'list' => 0,
			'search' => false,
			'form' => 'style="width:100%;"',
		),
		'cardName' => array(
			'name' => 'Title',
			'type' => 'text',
			'list' => '1',
			'form' => 'class="text"',
			'search' => true,
		),
		'comment' => array(
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