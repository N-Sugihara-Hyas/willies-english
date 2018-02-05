<?php


		$this->addModel(array('card/Anser'));

		$this->getCommon();

		$this->CardDetails->target = '*,card_anser.*';
		$arrayData = $this->CardAnser->getMy($this->arrayUser['id'], $this->uid)->getData();

		$arrayData['member_base_id'] = $this->arrayUser['id'];
		$arrayData['card_details_id'] = $this->uid;

		if (!empty($arrayData['isOK'])){
			$arrayData['isOK'] = 0;
		}else{
			$arrayData['isOK'] = 1;
		}
			
		$this->CardAnser->commit($arrayData);


		exit();
?>
