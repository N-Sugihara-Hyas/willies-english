<?php

	/*
	*	講師のスケジュールの再追加
	*/
	$this->addModel(array('member/Base', 'take/Reserve', 'member/Cancel', 'ext/HolidayReturn', 'cource/Style'));

	$timeStart = time();
	$timeEnd = time() + (3600 * 24 * 28);
	$arraySchedule = $this->MemberBase->getFunctionData('Schedule');

	//キャンセルしたものは削除
	$date2Start = date('Y-m-d', $timeStart);
	$date2End = date('Y-m-d', $timeEnd);

	$this->MemberCancel->addQuery('cancelDate >=', $date2Start);
	$this->MemberCancel->addQuery('cancelDate <=', $date2End);
	$dbGet2 = $this->MemberCancel->getData();
	

	
	for ($timeNow = $timeStart; $timeNow <= $timeEnd; $timeNow++){
		$date = '';
		$w = date('w', $timeNow);


		foreach ($arraySchedule as $item){
			if (strpos($item['week'], $w) !== FALSE){
				$date = date('Y-m-d', $timeNow);
				$wID = $item['id'];
			}
		}
		
		if ($date){
			if (isset($wID)){		
				$this->MemberBase->addQuery('cource_schedule_id', $wID);
				$this->MemberBase->addQuery('timeStart IS NOT NULL');
				$this->MemberBase->addQuery('take_base_id<>0');
				$this->MemberBase->addQuery('state', 3);

				$dbGet = $this->MemberBase->getData();
				
				
				while ($item = $dbGet->getData()){
					//そのスケジュールで、その講師が確保ができるか再チェック
					$this->TakeReserve->isB = true;

					$this->CourceStyle->addQuery('id', $item['cource_style_id']);
					$arrayCourceStyle = $this->CourceStyle->getData()->getData();

					if ($this->TakeReserve->getDataTime($item['cource_base_id'], $date, $item['timeStart'], $arrayCourceStyle['weekTime'],1, $item['take_base_id'])){
						$this->TakeReserve->addDataTime($item['id'], $date, $item['timeStart'], $arrayCourceStyle['weekTime'], $item['cource_style_id'], $item['take_base_id'], 1,false);
					}
				}
				
			}
		}

		$timeNow += 3600 * 24;
	}


	while ($item = $dbGet2->getData()){		
		$this->TakeReserve->addQuery('date', $item['cancelDate']);
		$this->TakeReserve->addQuery('member_base_id', $item['member_base_id']);
		$this->TakeReserve->delData();
	}
	exit();

?>