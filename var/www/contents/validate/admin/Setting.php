<?php

class ValidateAdminSetting extends Validate{
	var $validate = array(
		'title' => array(
		array(
			'type' => 'NonSpace',
			'message' => '未入力です。'
			),
		),

		'keyID' => array(
			array(
				'type' => 'NonSpace',
				'message' => '未入力です。'
			),
			array(
				'type' => 'English',
				'message' => '半角英数字で入力して下さい。'
			),
			array(
				'type' => 'StringMax',
				'num' => '30',
				'message' => '30文字以内で入力して下さい'
			),
		),

		'value' => array(
		array(
			'type' => 'NonSpace',
			'message' => '未入力です。'
			),
		),

	);
}

?>
