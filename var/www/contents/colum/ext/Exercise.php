<?php

	$arrayColum = array(
		'japan' => array(
			'name' => 'こちらに日本語文を書き込んでください。',
			'type' => 'textarea',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => 'style="width:100%;height:10em;"',
			'search' => true,
		),
		'english' => array(
			'name' => 'こちらに日本文の英訳に挑戦してみてください。',
			'type' => 'textarea',
			'list' => '0',
			'api'	=> '/api/imgMedia/',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => 'style="width:100%;height:10em;"',
			'search' => false,
		),
	);

	$self->parent->updateDataOut = function() use($self){

	};

	$self->parent->updateData = function() use($self){
		//ユーザーからの情報を入れる
		$self->arrayData['member_base_id'] = $self->arrayUser['id'];
		$self->arrayData['take_base_id'] = $self->arrayUser['take_base_id'];
	};


?>