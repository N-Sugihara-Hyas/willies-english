<?php

	addModel('ModelDB');

	/*
	*	ユーザーの音読レッスンの予約状況のクラス
	*/
	class MemberDaily extends ModelDB{
	var $tableName = 'member_daily';

		function setReserver($tID, $date, $time){
			$this->addQuery('take_base_id', $tID);
			$this->addQuery('datetime', $date . ' ' . $time);

			$arrayResult = $this->getData()->getData();

			if (empty($arrayResult['count'])){$arrayResult['count'] = 0;}
			
			$arrayResult['take_base_id'] = $tID;
			$arrayResult['datetime'] =$date . ' ' . $time;
			$arrayResult['count']++;
			
			$this->commit($arrayResult);
		}
	}

?>