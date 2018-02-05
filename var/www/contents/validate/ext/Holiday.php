<?php

class ValidateExtHoliday extends Validate{
	var $validate = array(
		'date' => array(
			array(
				'type' => 'NonSpace',
				'message' => '入力されてません'
			),
		),
	);
	
}

?>
