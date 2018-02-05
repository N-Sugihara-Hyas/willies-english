<?php


	$this->addModel(array('take/Reserve', 'master/AdminNews'));

	$this->TakeReserve->addQuery('date', date('Y-m-d'));
	$this->TakeReserve->addQuery('isTrial', 1);
	$this->TakeReserve->addQuery('member_base_id <>', 0);

	$this->TakeReserve->joinTakeBase();
	$dbGet = $this->TakeReserve->getData();

	while ($item = $dbGet->getData()){
		if ($item['email']){
			$this->MasterAdminNews->sendMailTrial($item);
		}
	}

	exit();

?>