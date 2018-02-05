<?php

class ValidateCourceBase extends Validate{
	var $validate = array(
		'courceName' => array(
			array(
				'type' => 'NonSpace',
				'message' => '未入力です'
			),
		),
	);
	
}

?>
