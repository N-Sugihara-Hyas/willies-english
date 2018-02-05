<?php
/*
*	トピックスリストの読み込み
*/
	$this->addModel(array('take/ScheduleView', 'take/Base', 'take/Reserve', 'take/Schedule', 'take/Cancel', 'cource/Style'));

	$this->getCommon();

	$arraySet = $this->TakeScheduleView->setView($this->arrayAll);

	foreach ($arraySet as $key => $item){
		$this->set($key, $item);
	}

	//カウンターの取得
	$takeName = getVar($this->arrayAll, 'takeName');

	//日時
	if (!empty($this->arrayAll['dateStart'])){
		$dateStart = $this->arrayAll['dateStart'];
	}else{
		$dateStart = date('Y-m-d');
	}
	if (!empty($this->arrayAll['dateEnd'])){
		$dateEnd = $this->arrayAll['dateEnd'];
	}else{
		$dateEnd = date('Y-m-d');
	}

	$timeStart = strtotime($dateStart . ' 00:00:00');
	$timeEnd = strtotime($dateEnd . ' 23:59:59');

	if ($takeName){
		$this->TakeBase->addQuery('nickname', $takeName);
	}

	$arrayTakeBase = $this->TakeBase->getData()->getDataAll();

	$this->CourceStyle->order = 'styleType ASC';
	$this->CourceStyle->group = 'styleType';
	$dbGet = $this->CourceStyle->getData();

	$i = 0;
	while ($item = $dbGet->getData()){
		$arrayType[$i] = $item['styleType'];
		$arrayType2[$i] = $item['weekTime'];
		$i++;
	}

	$arrayPay = array();

	foreach ($arrayType as $item2){
		$arrayPay[$item2] = 0;
	}

	$arrayPay[5] = 0;
	$arrayPay[6] = 0;
	$arrayPay[7] = 0;

	for ($i = $timeStart; $i <= $timeEnd;){
		foreach ($arrayTakeBase as $item){
			$total = 0;
			$totalTime = 0;
			$date = date('Y-m-d', $i);


			foreach ($arrayType as $key => $item2){
				$this->TakeReserve->joinCourceStyle();
				$this->TakeReserve->addQuery('date', $date);
				$this->TakeReserve->addQuery('take_base_id', $item['id']);
				$this->TakeReserve->group = 'timeStart';
				$this->TakeReserve->addQuery('styleType', $item2);

				$arrayPay[$date][$item['id']][$item2] = $this->TakeReserve->getData()->getCount();
				$arrayPay[$item2]+= $arrayPay[$date][$item['id']][$item2];

				$total+=$arrayPay[$date][$item['id']][$item2];
				if ($arrayPay[$date][$item['id']][$item2] ){
					$totalTime+=(intval($arrayType2[$key]) / 50) * $arrayPay[$date][$item['id']][$item2];
				}
			}
			$this->TakeReserve->addQuery('date', $date);
			$this->TakeReserve->addQuery('take_base_id', $item['id']);
			$this->TakeReserve->addQuery('type', 4);
			$this->TakeReserve->group = 'timeStart';

			$arrayPay[$date][$item['id']][5] = $this->TakeReserve->getData()->getCount();
			$arrayPay[5]+= $arrayPay[$date][$item['id']][5];
			$total+= $arrayPay[$date][$item['id']][5];
			$totalTime+= $arrayPay[$date][$item['id']][5];

			//勤務数取得
			$this->TakeSchedule->addQuery('take_base_id', $item['id']);
			$this->TakeSchedule->addQuery('type', 1);
			$this->TakeSchedule->addQuery('week', date('w', $i));
			$dbGet = $this->TakeSchedule->getData();

			$arraySch = $dbGet->getDataAll();
			$countSch = $dbGet->getCount();

			$countLesson = 0;

			//まずはレギュラースケジュールの実行数を算出
			if ($arraySch){
				$this->TakeReserve->joinCourceStyle();
				$this->TakeReserve->group = 'timeStart';

				foreach ($arraySch as $itemSch){
					$this->TakeReserve->addQuery('OR (1');
					$this->TakeReserve->addQuery('take_base_id', $item['id']);
					$this->TakeReserve->addQuery('date', $date);
					$this->TakeReserve->addQuery('type > 0');
					$this->TakeReserve->addQuery('timeStart', $itemSch['time']);
					$this->TakeReserve->addQuery('1)');
				}
				$dbGet2 = $this->TakeReserve->getData();

				while ($itemRev = $dbGet2->getData()){
					$countLesson+=intval($itemRev['weekTime']) / 50;
				}
			}

			
			$arrayPay[$date][$item['id']][6] = $totalTime - ($countSch - ($countSch - $countLesson));
			//$arrayPay[$date][$item['id']][6] = $countLesson . '/' . $totalTime;

			if ($arrayPay[$date][$item['id']][6] < 0){$arrayPay[$date][$item['id']][6] = 0;}

			$arrayPay[6]+= $arrayPay[$date][$item['id']][6];

			//休日の取得
			$this->TakeReserve->group = 'timeStart';
			$this->TakeReserve->addQuery('date', $date);
			$this->TakeReserve->addQuery('take_base_id', $item['id']);
			$this->TakeReserve->addQuery('type', -2);
			$arrayPay[$date][$item['id']][7] = $this->TakeReserve->getData()->getCount() / 2;

			$arrayPay[7]+= $arrayPay[$date][$item['id']][7];
		}


		$i+=3600*24;
	}

	


	$this->set('arrayType', $arrayType);
	$this->set('arrayPay', $arrayPay);
	$this->set('isNotView', getVar($this->arrayAll, 'isNotView'));
	$this->set('isChange', getVar($this->arrayAll, 'isChange'));
	$this->set('isCounter', 1);

?>