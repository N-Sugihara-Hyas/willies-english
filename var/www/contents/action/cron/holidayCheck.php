<?php

	/*
	*	休日の場合の振替ポイント
	*/
	$this->addModel(array('ext/Holiday', 'ext/HolidayReturn', 'member/Base', 'member/Point', 'take/Base', 'take/Reserve'));


	//7日後設定
	$day = 0;
	$date = date('Y-m-d', time() + (1 * 3600 * 24));
	$dateEnd = date('Y-m-d', time() + (62 * 3600 * 24));

	
	$this->ExtHoliday->addQuery('dateStart >=', $date);
	$this->ExtHoliday->addQuery('dateEnd <=', $dateEnd);
	$dbGet = $this->ExtHoliday->getData();

	while ($item = $dbGet->getData()){		
		//全講師の予約をブロック
		$arrayTakeBase = $this->TakeBase->getData()->getDataAll();
				
		list($date, $time) = explode(' ', $item['dateStart']);
		list($dateEnd, $timeEnd) = explode(' ', $item['dateEnd']);
		
		//休日に予約が入ってる方がいたら、削除し、ポイントを渡す予定を入れる
		$this->TakeReserve->addQuery('date', $date);
		$this->TakeReserve->addQuery('type <>', -1);
		$this->TakeReserve->addQuery('member_base_id >', 0);
		
		$dbGet2 = $this->TakeReserve->getData();
		
		while ($itemR = $dbGet2->getData()){
			//余計な予約のため、ポイント予約を入れる
			$this->ExtHolidayReturn->addDataReturn($itemR['member_base_id'], $itemR['date'], $itemR['timeStart']);
			
			$this->TakeReserve->addQuery('id', $itemR['id']);
			$this->TakeReserve->delData();
		}
		
		//休日はブロックをチェックし、登録する
		for ($i = strtotime($date . ' ' . $time); $i <= strtotime($dateEnd . ' ' . $timeEnd); ){
			$dateP = date('Y-m-d', $i);
			$timeP = date('H:i:s', $i);
			
			foreach ($arrayTakeBase as $item2){
				$this->TakeReserve->delDataTime(0, $dateP, $timeP, 25, 0, $item2['id'], -1);
				$this->TakeReserve->addDataTime(0, $dateP, $timeP, 25, 0, $item2['id'], -1);
			}

			$i+=1800;
		}

	}
	exit();

?>