<?php

class ValidateCourceBaseDaily extends Validate{
	var $validate = array(
		'courceName' => array(
			array(
				'type' => 'NonSpace',
				'message' => '未入力です'
			),
		),
		'level' => array(
			array(
				'type' => 'NonSpace',
				'message' => '未入力です'
			),
			array(
				'type' => 'Number',
				'message' => '半角数字で入力してください'
			),

		),

	);
	
}

?>
