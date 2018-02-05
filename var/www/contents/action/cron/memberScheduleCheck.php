<?php

	/*
	*	講師のスケジュールの再追加
	*/
	$this->addModel(array('member/Base', 'take/Reserve', 'member/Cancel', 'member/CancelTrial', 'take/Cancel'));


	$this->MemberBase->addQuery('cource_schedule_id IS NOT NULL');
	$this->MemberBase->addQuery('timeStart IS NOT NULL');
	$this->MemberBase->addQuery('take_base_id<>0');
	$this->MemberBase->addQuery('state <=', 3);
	$dbGet = $this->MemberBase->getData();	
	
	$arraySchedule = $this->MemberBase->getFunctionData('Schedule');
		
	echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
	
	while ($item = $dbGet->getData()){

		$dateNow = time() + (3600  *24);
		$dateLimit = $dateNow + (3600  *24 * 7);
		
		for ($i = $dateNow; $i < $dateLimit;){
			$skypeTime = strtotime($item['timeEnd']) - strtotime($item['timeStart']);
			$skypeTime = $skypeTime / 60;
			$dateCheck = date('Y-m-d', $i);
			$week = date('w', $i);
			$isCheck = false;
			
			$arrayWeek = explode(',', $arraySchedule[$item['cource_schedule_id']]['week']);
			
			foreach ($arrayWeek as $item2){
				if ($week == $item2){
					$isCheck = true;
				}
			}
			
			
			if ($isCheck){				
				$this->TakeReserve->isMemberCheck = false;
				
				if ((!$item['dateUnRegist']) || (strtotime($item['dateUnRegist']) >= $dateNow)){
					if ($this->TakeReserve->getDataTime($item['cource_base_id'], $dateCheck, $item['timeStart'], $skypeTime, 1, $item['take_base_id'])){				
						//キャンセル関連
						$this->MemberCancel->addQuery('member_base_id', $item['id']);
						$this->MemberCancel->addQuery('cancelDate', $dateCheck);
						$this->MemberCancel->addQuery('cancelTime', $item['timeStart']);
						$arrayCancel = $this->MemberCancel->getData()->getData();
						
						if (!$arrayCancel){	
							//キャンセル関連(トライアル)
							$this->MemberCancelTrial->addQuery('member_base_id', $item['id']);
							$this->MemberCancelTrial->addQuery('cancelDate', $dateCheck);
							$this->MemberCancelTrial->addQuery('cancelTime', $item['timeStart']);
							$arrayCancel = $this->MemberCancelTrial->getData()->getData();
														
							if (!$arrayCancel){
								$this->TakeReserve->addModelTool('Mail');
								
								$this->TakeReserve->arrayData = $item;
								$this->TakeReserve->arrayMail['domain'] = $this->arraySetting['domain'];
								$this->TakeReserve->arrayData['created'] = date('Y-m-d');
								$this->TakeReserve->arrayData['date'] = $dateCheck;
								$this->TakeReserve->arrayData['timeStart2'] = $item['timeStart'];
								
								$this->TakeReserve->mailSend(51, array($this->arraySetting['email']));
							}
						}
					}
				}
			}
			
			$i += 3600 * 24;
		}
		//print_r($item);
		//$this->TakeReserve
	}
	exit();

?>