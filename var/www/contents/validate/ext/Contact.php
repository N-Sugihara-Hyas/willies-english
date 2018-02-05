<?php

class ValidateExtContact extends Validate{
	var $validate = array(
		'name' => array(
			array(
				'type' => 'NonSpace',
				'message' => 'お名前が入力されてません'
			),
		),
		'body' => array(
			array(
				'type' => 'NonSpace',
				'message' => '本文が入力されてません'
			),
		),
	);
	
}

?>
