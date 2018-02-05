<?php

	/*
	*	支払いの無い人間のコースのキャンセルの処理
	*/
	$this->addModel(array('take/Reserve'));
		

	$result = $this->TakeReserve->query("SELECT take_reserve.id, take_reserve.date, take_reserve.timeStart, take_reserve.timeEnd FROM  `take_reserve`  LEFT JOIN member_base ON member_base.id = take_reserve.member_base_id WHERE take_reserve.timeEnd LIKE  '%:25:%' AND member_base_id <>0 AND cource_style_id =1");

	while ($row = $result->fetch(PDO::FETCH_ASSOC)){
		$row['timeEnd'] = date('H:i:s', strtotime($row['timeEnd']) + 60 * 25);

		$arrayData['id'] = $row['id'];
		$arrayData['timeEnd'] = $row['timeEnd'];
		$this->TakeReserve->commit($arrayData);
	}

	exit();
		
?>