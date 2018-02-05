<?php

class ValidateExtExerciseTake extends Validate{
	var $validate = array(
		'english' => array(
			array(
				'type' => 'NonSpace',
				'message' => 'Non String'
			),
		),
		'takeComment' => array(
			array(
				'type' => 'NonSpace',
				'message' => 'Non String'
			),
		),
	);
	
}

?>
