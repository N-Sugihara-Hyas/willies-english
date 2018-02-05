<?php

class ValidateMemberMenu extends Validate{
	var $validate = array(
		'subject' => array(
		array(
			'type' => 'NonSpace',
			'message' => '未入力です'
			),
		),

	);
	
}

?>
