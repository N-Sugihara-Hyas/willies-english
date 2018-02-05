<?php

class ValidateMemberMemoCategory extends Validate{
	var $validate = array(
		'categoryName' => array(
			array(
				'type' => 'NonSpace',
				'message' => '未入力です'
			),
			array(
				'type' => 'StringMax',
				'num' => 122,
				'message' => '全角で122文字以上で入力して下さい'
			),
		),
	);
	
}

?>
