<?php

class ValidateExtHomeworkBook extends Validate{
	var $validate = array(
		'title' => array(
			array(
				'type' => 'NonSpace',
				'message' => '‹ó”’‚Å‚·'
			),
		),
	);
	
}

?>
