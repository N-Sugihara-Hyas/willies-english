<?php

class ValidateCardBase extends Validate{
	var $validate = array(
		'cardName' => array(
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
