<?php
	require_once 'Message.php';

	$arrayColumAdmin = array(
		'to_id' => array(
			'name' => 'Select Teachers',
			'type' => 'select',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'data' => 'TakeBaseAll',
			'search' => true,
		),
	);

	$arrayColum = array_merge($arrayColum, $arrayColumAdmin);

	$self->parent->updateData = function() use($self){		
		$self->arrayData['isManage'] = 1;

		$self->arrayData['from_id'] = -1;
	};


?>