<?php

class ValidateExtFeedBack extends Validate{
	var $validate = array(
		'name' => array(
			array(
				'type' => 'NonSpace',
				'message' => '入力されてません'
			),
		),
		'date' => array(
			array(
				'type' => 'NonSpace',
				'message' => '入力されてません'
			),
		),
		'time' => array(
			array(
				'type' => 'NonSpace',
				'message' => '入力されてません'
			),
		),

		'body' => array(
			array(
				'type' => 'NonSpace',
				'message' => '入力されてません'
			),
		),
	);
	
}

?>
