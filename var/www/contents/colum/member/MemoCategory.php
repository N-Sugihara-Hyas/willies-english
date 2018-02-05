<?php

	$arrayColum = array(
		'categoryName' => array(
			'name' => 'カテゴリ名',
			'type' => 'text',
			'list' => '0',
			'search' => false,
			'labelBack' => '<span class="attBox">*</span>',
			'form' => 'style="width:80%;"',
		),
	);
	
	
	$self->parent->updateData = function() use($self){
		$self->arrayData['member_base_id'] = $self->arrayUser['id'];
	};


?>