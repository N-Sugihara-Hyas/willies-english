<?php

class ValidateTeachingBase extends Validate{
	var $validate = array(
		'teachingName' => array(
			array(
				'type' => 'NonSpace',
				'message' => 'not entered'
			),
		),
		'sort' => array(
			array(
				'type' => 'NonSpace',
				'message' => 'not entered'
			),
		),

	);
	
}

?>
