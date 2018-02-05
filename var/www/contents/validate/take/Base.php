<?php

class ValidateTakeBase extends Validate{
	var $validate = array(
		'takeName' => array(
			array(
				'type' => 'NonSpace',
				'message' => 'not entered'
			),
		),
		'address' => array(
			array(
				'type' => 'NonSpace',
				'message' => 'not entered'
			),
		),
		'nickname' => array(
			array(
				'type' => 'NonSpace',
				'message' => 'not entered'
			),
		),
		'email' => array(
			array(
				'type' => 'NonSpace',
				'message' => 'not entered'
			),
		),
		'tel' => array(
			array(
				'type' => 'NonSpace',
				'message' => 'not entered'
			),
		),
		'skypeID' => array(
			array(
				'type' => 'NonSpace',
				'message' => 'not entered'
			),
		),

	);
	
}

?>
