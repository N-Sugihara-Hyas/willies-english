<?php

	$self->modelImage = 'media/Image';

	$arrayColum = array(
		'subject' => array(
			'name' => 'メニュー名',
			'type' => 'text',
			'list' => '1',
			'form' => 'style="width:70%;"',
			'search' => 1,
		),
		'body' => array(
			'name' => '本文',
			'type' => 'editor',
			'list' => '0',
			'form' => 'style="width:70%;height:6em;"',
			'search' => 0,
		),
		'url' => array(
			'name' => 'リンク先をリンクに<br />する場合記入',
			'type' => 'text',
			'list' => '0',
			'form' => 'style="width:70%;"',
			'search' => 0,
		),
		'sort' => array(
			'name' => '並び順<br />（小さな数字ほど上に）',
			'type' => 'text',
			'list' => '0',
			'form' => 'style="width:20%;"',
			'search' => 0,
		),
		'fileName1' => array(
			'name' => 'ファイルを設置1',
			'type' => 'file',
			'list' => '0',
			'form' => 'style="width:70%;"',
			'search' => 0,
		),
		'fileName2' => array(
			'name' => 'ファイルを設置2',
			'type' => 'file',
			'list' => '0',
			'form' => 'style="width:70%;"',
			'search' => 0,
		),
		'fileName3' => array(
			'name' => 'ファイルを設置3',
			'type' => 'file',
			'list' => '0',
			'form' => 'style="width:70%;"',
			'search' => 0,
		),
		'fileName4' => array(
			'name' => 'ファイルを設置4',
			'type' => 'file',
			'list' => '0',
			'form' => 'style="width:70%;"',
			'search' => 0,
		),
		'fileName5' => array(
			'name' => 'ファイルを設置5',
			'type' => 'file',
			'list' => '0',
			'form' => 'style="width:70%;"',
			'search' => 0,
		),
	);

?>