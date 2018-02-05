<?php

	/*
	*	講師のスケジュールの再追加
	*/
	$this->addModel(array('member/Base', 'take/Reserve', 'ext/HolidayReturn', 'cource/Style'));


	
	$time = time() + (3600 * 24 * $this->arraySetting['maxSchedule']);
	$dateMax = date('Y-m-d', $time);
	
	$arraySchedule = $this->MemberBase->getFunctionData('Schedule');

	$timeStart = strtotime($dateMax) - (3600  * 24);
	$timeEnd = strtotime($dateMax);
	


	for ($timeNow = $timeStart; $timeNow <= $timeEnd; $timeNow++){
		$date = '';
		$w = date('w', $timeNow);


		$arrayWeek = $this->MemberBase->getWeek($w);
		$date = date('Y-m-d', $timeNow);
		
		if ($date){
			if ($arrayWeek){	
				$this->MemberBase->addQuerySchedule($arrayWeek);
				$this->MemberBase->addQuery('timeStart IS NOT NULL');
				$this->MemberBase->addQuery('take_base_id<>0');
				$this->MemberBase->addQuery('state <=', 3);
				//$this->MemberBase->addQuery('state <>', 2);

				$dbGet = $this->MemberBase->getData();
				
				
				while ($item = $dbGet->getData()){
					//そのスケジュールで、その講師が確保ができるか再チェック
					$this->TakeReserve->isB = true;

					$this->CourceStyle->addQuery('id', $item['cource_style_id']);
					$arrayCourceStyle = $this->CourceStyle->getData()->getData();

					if ($this->TakeReserve->getDataTime($item['cource_base_id'], $date, $item['timeStart'], $arrayCourceStyle['weekTime'],1, $item['take_base_id'])){
						$this->TakeReserve->addDataTime($item['id'], $date, $item['timeStart'], $arrayCourceStyle['weekTime'], $item['cource_style_id'], $item['take_base_id'], 1,false);
					}else{
						//休日用にポイントを付けるリスト
						if ($this->TakeReserve->arrayJudg['member_base_id'] != $item['id']){
							//自分の予約が入っている場合は無視
							$this->ExtHolidayReturn->addDataReturn($item['id'], $date, $item['timeStart']);
						}
					}

				}				
			}
		}

		$timeNow += 3600 * 24;
	}

	exit();

?>