<?php

	/*
	*	講師のスケジュールの再追加
	*/
	$this->addModel(array('member/Base', 'take/Reserve', 'ext/HolidayReturn', 'cource/Style'));


	ini_set( 'display_errors', 1 );
	
	$time = strtotime($this->arrayAll['date']) + (3600  * 24) ;
	$dateMax = date('Y-m-d', $time);
	
	$arraySchedule = $this->MemberBase->getFunctionData('Schedule');
	
	$timeStart = strtotime($this->arrayAll['date']);
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
							echo $item['id'] . '<br />';
							
								//$this->TakeReserve->addDataTime($item['id'], $date, $item['timeStart'], $arrayCourceStyle['weekTime'], $item['cource_style_id'], $item['take_base_id'], 1,false);				
						}
				}				
			}
		}

		$timeNow += 3600 * 24;
	}

	echo 'End';
	exit();

?>