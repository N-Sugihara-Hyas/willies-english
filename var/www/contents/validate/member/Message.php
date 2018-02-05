<?php

class ValidateMemberMessage extends Validate{
	var $validate = array(
		'message' => array(
			array(
				'type' => 'NonSpace',
				'message' => 'not entered'
			),
		),
	);

}

?>
