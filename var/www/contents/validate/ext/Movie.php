<?php

class ValidateExtMovie extends Validate{
	var $validate = array(
		'movieName' => array(
			array(
				'type' => 'NonSpace',
				'message' => '動画名が入力されてません'
			),
		),

	);
	
}

?>
