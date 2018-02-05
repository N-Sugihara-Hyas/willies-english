<?php

	$arrayColum = array(
		'url' => array(
			'name'	=> 'URL',
			'type'	=> 'text',
			'form'  => ' size="30"',
			'search' => true,
			'list'	=> 1
		),
		'subject' => array(
			'name' 	=> 'ページタイトル',
			'type'	=> 'text',
			'form'  => ' size="30"',
			'list'	=> 1,
			'search' => true,
		),

		'body' => array(
			'name' 	=> '内容',
			'type'	=> 'editor',
			'list'	=> 0,
			'form' => 'style="width:90%;"', 
			'search' => false,
		),
	);

?>