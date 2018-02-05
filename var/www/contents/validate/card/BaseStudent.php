<?php

class ValidateCardBaseStudent extends Validate{
	var $validate = array(
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
