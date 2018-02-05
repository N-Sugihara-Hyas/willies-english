<?php


	$this->addModel(array('take/Reserve'));


	$this->TakeReserve->target = '*,take_reserve.*';
	$this->TakeReserve->joinTakeBase();
	$dbGet = $this->TakeReserve->getStandbyHistoryMail();

	$this->TakeReserve->addModelTool('Mail');

	while ($item = $dbGet->getData()){


		$this->TakeReserve->arrayMail = $item;
		$this->TakeReserve->arrayMail['domain'] = $this->arraySetting['domain'];
		$this->TakeReserve->arrayMail['timeStart2'] = date('H:i', strtotime($this->TakeReserve->arrayMail['timeStart']));

		$this->TakeReserve->mailSend(34, array($item['email']));


		$this->TakeReserve->setDataUID($item['id'], array('isOkMail' => 1));
	}
	exit();

?>