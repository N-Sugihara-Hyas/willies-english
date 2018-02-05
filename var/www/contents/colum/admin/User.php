<?php

	$arrayColum = array(
		'name' => array(
			'name'	=> '管理者名',
			'type'	=> 'text',
			'list'	=> 1,
			'search' => true,
			'form' => '',
		),
		'adminType' => array(
			'name'	=> '管理者種別',
			'type'	=> 'select',
			'list'	=> 1,
			'data' => 'AdminType',
			'search' => true,
			'form' => '',
		),
		'la' => array(
			'name'	=> '言語',
			'type'	=> 'select',
			'list'	=> 1,
			'data' => 'AdminLanguage',
			'search' => true,
			'form' => '',
		),
		'email' => array(
			'name' 	=> 'メールアドレス',
			'type'	=> 'text',
			'form'  => ' size="60"',
			'list'	=> 1,
			'search' => true,
			'form' => '',
		),

		'loginID' => array(
			'name' 	=> 'ログインID',
			'type'	=> 'text',
			'list'	=> 0,
			'search' => false,
			'form' => '',
		),
		'pass' => array(
			'name' 	=> 'パスワード',
			'type'	=> 'password',
			'list'	=> 0,
			'search' => false,
			'form' => '',
		),
		'passConf' => array(
			'name' 	=> 'パスワード(確認用)',
			'type'	=> 'password',
			'list'	=> 0,
			'search' => false,
			'form' => '',
		),
	);

	$self->parent->updateDataOut = function() use($self){		
		$self->arrayInput['pass'] = $self->getDecode($self->arrayInput['pass']);
	};

	$self->parent->updateData = function() use($self){		
		$self->arrayData['pass'] = $self->getEncode($self->arrayData['pass']);
		unset($self->arrayData['passConf']);

	};


?>