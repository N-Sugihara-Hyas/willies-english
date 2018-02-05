<?php

	/*
	*	支払いのチェック
	*/
	$this->addModel(array('member/Base'));
	$this->addLiblary(array('tool/Paypal'));

	$this->MemberBase->addQuery('orderID1 IS NOT NULL');
	$this->MemberBase->addQuery('OR orderID2 IS NOT NULL');

	$dbGet = $this->MemberBase->getData();
	
	$Paypal = new Paypal();
	
	while ($item = $dbGet->getData()){		
		$res = $Paypal->check_status($item['orderID1']);
			
		if ($res["STATUS"] != "Active"){
			//決済に問題がある場合は、その人間は支払い不能と判断
			$item['isPay'] = 0;
			$this->MemnerBase->commit($item);
		}

		$res = $Paypal->check_status($item['orderID2']);
			
		if ($res["STATUS"] != "Active"){
			//決済に問題がある場合は、その人間は支払い不能と判断
			$item['isPayDaily'] = 0;
			$this->MemnerBase->commit($item);
		}

	}
	
?>