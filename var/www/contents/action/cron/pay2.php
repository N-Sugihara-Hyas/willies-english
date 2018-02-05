<?php

	/*
	*	支払状況のチェック
	*/
	$this->addModel(array('member/Base', 'take/Reserve'));
	$this->addLiblary(array('tool/Paypal'));


	$Paypal = new Paypal('company_api1.williesenglish.com', 'GGRWEV4GDSQDD6AF', 'AFcWxV21C7fd0v3bYYYRCpSSRl31A-GB0mxAuBdIvGs-6H9xLMOFYpe7');
	$res = $Paypal->check_status($item['orderID1']);
	var_dump($res);

	
	exit();
		
?>