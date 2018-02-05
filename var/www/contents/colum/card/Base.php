<?php
	$arrayColum = array(
		'cardName' => array(
			'name' => 'Title',
			'type' => 'text',
			'list' => '1',
			'form' => 'class="text"',
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