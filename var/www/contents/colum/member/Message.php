<?php

	$arrayColum = array(
		'member_base_id' => array(
			'type' => 'hidden',
			'list' => '0',
			'search' => false,
		),
		'subject' => array(
			'name' => 'Subject',
			'type' => 'text',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => 'style="width:100%;"',
			'search' => true,
		),
		'message' => array(
			'name' => 'Message',
			'type' => 'textarea',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => 'style="width:100%;height:40em;"',
			'search' => true,
		),
	);
?>