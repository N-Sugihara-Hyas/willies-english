<?php

class ValidateMasterNews extends Validate{
	var $validate = array(
		'dateDay' => array(
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
