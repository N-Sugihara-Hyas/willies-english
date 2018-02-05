<?php

class ValidateCourceStyle extends Validate{
	var $validate = array(
		'courceStyleName' => array(
			array(
				'type' => 'NonSpace',
				'message' => '姓が未入力です'
			),
		),
		'weekCount' => array(
			array(
				'type' => 'NonSpace',
				'message' => '未入力です'
			),
			array(
				'type' => 'Number',
				'message' => '半角数字で入れて下さい(無い場合は0)'
			),
		),
		'weekTime' => array(
			array(
				'type' => 'NonSpace',
				'message' => '未入力です'
			),
			array(
				'type' => 'Number',
				'message' => '半角数字で入れて下さい(無い場合は0)'
			),
		),

	);
	
}

?>
