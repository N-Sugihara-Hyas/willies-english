<?php

class ValidateTeachingLesson extends Validate{
	var $validate = array(
		'category' => array(
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
