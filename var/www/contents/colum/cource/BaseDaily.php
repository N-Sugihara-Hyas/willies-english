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
		'level' => array(
			'name' => 'レベル',
			'type' => 'text',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => 'style="width:3em;"',
			'search' => true,
		),
		'comment' => array(
			'name' => 'コメント',
			'type' => 'textarea',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => 'style="width:90%;height:6em;"',
		),
		'timeStart' => array(
			'name' => '対応可能時間(開始)',
			'type' => 'select',
			'data' => 'Time',
			'list' => '1',
			'form' => '',
			'search' => false,
		),
		'timeEnd' => array(
			'name' => '対応可能時間(終了)',
			'type' => 'select',
			'data' => 'Time',
			'list' => '1',
			'form' => '',
			'search' => false,
		),
		'timeStart2' => array(
			'name' => '対応可能時間2(開始)',
			'type' => 'select',
			'data' => 'Time',
			'list' => '1',
			'form' => '',
			'search' => false,
		),
		'timeEnd2' => array(
			'name' => '対応可能時間2(終了)',
			'type' => 'select',
			'data' => 'Time',
			'list' => '1',
			'form' => '',
			'search' => false,
		),
	);


?>