<?php

	$arrayColum = array(
		'courceName' => array(
			'name' => 'コース名',
			'type' => 'text',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => '',
			'search' => true,
		),
		'courceNameEnglish' => array(
			'name' => 'コース名(英語)',
			'type' => 'text',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => '',
			'search' => true,
		),
		'arrayCourceStyle' => array(
			'name' => '対応レッスンプラン',
			'type' => 'checkbox',
			'data' => 'CourceStyle',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => '',
			'li' => '<br class="fc" />',
			'search' => false,
		),		
		'timeStart' => array(
			'name' => '対応可能時間(開始)',
			'type' => 'text',
			'data' => 'Time',
			'list' => '1',
			'form' => '',
			'search' => false,
		),
		'timeEnd' => array(
			'name' => '対応可能時間(開始)',
			'type' => 'text',
			'data' => 'Time',
			'list' => '1',
			'form' => '',
			'search' => false,
		),
		'timeStart2' => array(
			'name' => '対応可能時間２(開始)',
			'type' => 'text',
			'data' => 'Time',
			'list' => '1',
			'form' => '',
			'search' => false,
		),
		'timeEnd2' => array(
			'name' => '対応可能時間２(開始)',
			'type' => 'text',
			'data' => 'Time',
			'list' => '1',
			'form' => '',
			'search' => false,
		),
		'timeStart3' => array(
			'name' => '対応可能時間３(開始)',
			'type' => 'text',
			'data' => 'Time',
			'list' => '1',
			'form' => '',
			'search' => false,
		),
		'timeEnd3' => array(
			'name' => '対応可能時間３(開始)',
			'type' => 'text',
			'data' => 'Time',
			'list' => '1',
			'form' => '',
			'search' => false,
		),

	);


	$self->parent->updateDataOut = function() use($self){
		$SettingMeta = getModel('setting/Meta');

		$self->arrayInput['arrayCourceStyle'] = $SettingMeta->getMeta('arrayCourceStyle_' . $self->arrayInput['id']);

	};

	$self->parent->updateData = function() use($self){
		$self->arrayCourceStyle = $self->arrayData['arrayCourceStyle'];
		unset($self->arrayData['arrayCourceStyle']);
	};

	$self->parent->updateDataAffter = function($uid) use($self){
		$SettingMeta = getModel('setting/Meta');
		$SettingMeta->setMetaArray('arrayCourceStyle_' . $uid, $self->arrayCourceStyle);
	};


?>