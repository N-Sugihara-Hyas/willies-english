<?php

	/*
	*	支払いの無い人間の体験終了の処理
	*/
	$this->addModel(array('member/Base', 'cource/Style'));
		
//	if (isset($this->arraySetting['isCron'])){		
		if (date('w') == 2){
			echo 'U';	
		}
//	}
	
	exit();
		
?>