<?php


	/*
	*	ポイントの異常な人の修正処理
	*/
	$this->addModel(array('member/Base', 'member/Cancel', 'take/Reserve', 'ext/HolidayReturn'));
		
	ini_set('display_errors', 'On');
	error_reporting(E_ALL);

	$this->MemberBase->addQuery('countReturn >', 4);
	$this->MemberBase->addQuery('countReturn >', 4);
	$dbGet = $this->MemberBase->getData();

	while ($item = $dbGet->getData()){
		echo $item['id'] . '/' . $item['memberNameSecound'] . '/' . $item['countReturn'] . '<br />';
	}

	/*while ($item = $dbGet->getData()){
		$this->MemberCancel->addQuery('member_base_id', $item['id']);
		$arrayCancel = $this->MemberCancel->getData()->getDataAll();

		$count = 0;

		$this->TakeReserve->addQuery('member_base_id', $item['id']);
		$this->TakeReserve->addQuery('type', 2);
		$arrayReserve = $this->TakeReserve->getData()->getDataAll();

		foreach ($arrayReserve as $item2){
			$count--;
		}

		if ($arrayCancel){
			foreach ($arrayCancel as $item3){
				$count++;
			}
			

			$this->ExtHolidayReturn->addQuery('dateTime <=', date('Y-m-d H:i:s'));
			$this->ExtHolidayReturn->addQuery('member_base_id', $item['id']);
			$arrayHolidayReturn = $this->ExtHolidayReturn->getData()->getDataAll();

			foreach ($arrayHolidayReturn as $item2){
				$count++;
			}

		}*/

		/*$this->TakeReserve->addQuery('member_base_id');
		echo $this->TakeReserve->getData()->getCount() . '<br />';

		//過去のスケジュールで妙な箇所
		if ($item['cource_schedule_id']){
			echo $item['cource_schedule_id'];
			echo $item['id'] . '/' . $item['memberNameSecound'] . ' '. $item['memberNameFirst'] . '/' . $count;

			if ($item['countReturn'] > $count){
				echo '/' . 'point down';
			}else{
				echo '/' . 'point up';
			}

			if ($item['isPay']){
				echo '/' . 'Regular';
			}else{
				echo '/' . 'Non Regular';
			}

			echo  '<br/ >';
		}
	}*/

	exit();
		
?>