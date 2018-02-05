<?php

class ValidateExtExercise extends Validate{
	var $validate = array(
		'japan' => array(
			array(
				'type' => 'NonSpace',
				'message' => '日本語文が入力されてません'
			),
		),
		'english' => array(
			array(
				'type' => 'NonSpace',
				'message' => '英訳が入力されてません'
			),
		),
	);
	
}

?>
