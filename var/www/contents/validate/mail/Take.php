<?php

class ValidateMailTake extends Validate{
	var $validate = array(
		'subject' => array(
			array(
				'type' => 'NonSpace',
				'message' => '–¢“ü—Í‚Å‚·'
			),
		),
		'body' => array(
			array(
				'type' => 'NonSpace',
				'message' => '–¢“ü—Í‚Å‚·'
			),
		),

	);
	
}

?>
