<?php

	$arrayColum = array(
		'subject' => array(
			'name' => '件名',
			'type' => 'text',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => 'style="width:100%;"',
			'search' => true,
		),
		'body' => array(
			'name' => '内容',
			'type' => 'textarea',
			'list' => '0',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => 'style="width:100%;height:50em;"',
			'search' => true,
		),
		'sort' => array(
			'name' => '並び順<br />（小さな数字ほど上に）',
			'type' => 'text',
			'list' => '0',
			'form' => 'style="width:20%;"',
			'search' => 0,
		),

	);


?>