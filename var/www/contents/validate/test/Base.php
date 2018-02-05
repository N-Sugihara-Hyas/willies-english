<?php

class ValidateTestBase extends Validate{
	var $validate = array(
		'test_base_id' => array(
			array(
				'type' => 'NonSpace',
				'message' => 'not entered'
			),
		),
		'body1' => array(
			array(
				'type' => 'NonSpace',
				'message' => 'not entered'
			),
		),
		'body2' => array(
			array(
				'type' => 'NonSpace',
				'message' => 'not entered'
			),
		),
	);
	
}

?>
