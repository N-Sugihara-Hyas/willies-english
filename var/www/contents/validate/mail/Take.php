<?php

class ValidateMailTake extends Validate{
	var $validate = array(
		'subject' => array(
			array(
				'type' => 'NonSpace',
				'message' => '�����͂ł�'
			),
		),
		'body' => array(
			array(
				'type' => 'NonSpace',
				'message' => '�����͂ł�'
			),
		),

	);
	
}

?>
