<?php

class ValidateAdminPage extends Validate{
	var $validate = array(
		'url' => array(
			array(
				'type' => 'NonSpace',
				'message' => '未入力です。'
			),
		),
	);
}

?>
