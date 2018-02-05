<?php

class ValidateTestType extends Validate{
	var $validate = array(
		'typeName' => array(
			array(
				'type' => 'NonSpace',
				'message' => 'not entered'
			),
		),
	);
	
}

?>
