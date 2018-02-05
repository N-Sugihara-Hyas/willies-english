<?php

class ValidateMemberMemo extends Validate{
	var $validate = array(
		'body' => array(
			array(
				'type' => 'NonSpace',
				'message' => '未入力です'
			),
			array(
				'type' => 'StringMax',
				'num' => 2000,
				'message' => '全角で1000文字以上で入力して下さい'
			),
		),
	);
	
}

?>
