<?php

class ValidateMailTake extends Validate{
	var $validate = array(
		'subject' => array(
			array(
				'type' => 'NonSpace',
				'message' => '未入力です'
			),
		),
		'body' => array(
			array(
				'type' => 'NonSpace',
				'message' => '未入力です'
			),
		),

	);
	
}

?>
