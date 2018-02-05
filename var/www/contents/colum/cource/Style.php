<?php

	$arrayColum = array(
		'courceStyleName' => array(
			'name' => 'プラン名',
			'type' => 'text',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => '',
			'search' => true,
		),
		'courceStyleNameEnglish' => array(
			'name' => 'プラン名(英語)',
			'type' => 'text',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => '',
			'search' => true,
		),
		'styleType' => array(
			'name' => 'プランの区分',
			'type' => 'text',
			'list' => '1',
			'form' => 'style="width:30%"',
			'search' => false,
		),
		'weekCount' => array(
			'name' => '(レギュラーコース)回数',
			'type' => 'text',
			'list' => '0',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => 'style="width:30%"',
			'search' => false,
		),
		'weekTime' => array(
			'name' => '(レギュラーコース)１回当り時間',
			'type' => 'text',
			'list' => '0',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => 'style="width:30%"',
			'search' => false,
		),
		'weekSchedule' => array(
			'name' => '(レギュラーコース)対応レッスンスケジュール',
			'type' => 'checkbox',
			'list' => '0',
			'data' => 'Schedule',
			'search' => false,
		),
		'weekReturn' => array(
			'name' => '(レギュラーコース)振替有りか',
			'type' => 'checkbox',
			'list' => '0',
			'checkValue' => '有り',
			'search' => false,
		),
		'weekTake' => array(
			'name' => '(レギュラーコース)担任の有無',
			'type' => 'checkbox',
			'list' => '0',
			'checkValue' => '有り',
			'search' => false,
		),
		'weekMoney' => array(
			'name' => 'レギュラーレッスンの料金',
			'type' => 'text',
			'list' => '1',
			'form' => 'style="width:30%"',
			'search' => false,
		),
		'groupMoney' => array(
			'name' => '音読の料金',
			'type' => 'text',
			'list' => '1',
			'form' => 'style="width:30%"',
			'search' => false,
		),
	);

	$self->parent->updateDataOut = function() use($self){
		$SettingMeta = getModel('setting/Meta');

		$self->arrayInput['weekSchedule'] = $SettingMeta->getMeta('weekSchedule_' . $self->arrayInput['id']);

	};

	$self->parent->updateData = function() use($self){
		$self->arrayWeekSchedule = $self->arrayData['weekSchedule'];
		unset($self->arrayData['weekSchedule']);
	};

	$self->parent->updateDataAffter = function($uid) use($self){
		$SettingMeta = getModel('setting/Meta');
		$SettingMeta->setMetaArray('weekSchedule_' . $uid, $self->arrayWeekSchedule);
	};

?>