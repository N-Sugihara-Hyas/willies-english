<?php

class ValidateAdminMail extends Validate{
	var $validate = array(
		'from' => array(
			array(
				'type' => 'NonSpace',
				'message' => '未入力です。'
			),
		),
		'fromTitle' => array(
			array(
				'type' => 'NonSpace',
				'message' => '未入力です。'
			),
		),

		'subject' => array(
			array(
				'type' => 'NonSpace',
				'message' => '未入力です。'
			),
		),

		'body' => array(
			array(
				'type' => 'NonSpace',
				'message' => '未入力です。'
			),
		),


	);
	


}

?>
