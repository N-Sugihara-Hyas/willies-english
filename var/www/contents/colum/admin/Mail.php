<?php

	$arrayColum = array(
		'from' => array(
			'name'	=> 'メールの送り元',
			'type'	=> 'text',
			'list'	=> 1,
			'search' => false,
			'form' => '',
		),

		'fromTitle' => array(
			'name' 	=> 'メールの送り元の件名',
			'type'	=> 'text',
			'form'  => ' size="60"',
			'list'	=> 1
		),

		'subject' => array(
			'name' 	=> '件名',
			'type'	=> 'text',
			'form'  => ' size="60"',
			'list'	=> 1,
			'search' => true,
		),

		'body' => array(
			'name' 	=> 'メールの内容',
			'type'	=> 'textarea',
			'form'  => ' cols="80" rows="40"',
			'list'	=> 0
		),
	);

?>