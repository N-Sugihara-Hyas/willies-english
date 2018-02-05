<?php

	addModel('ModelDB');

	/*
	*	休日の振替ポイントを渡す人
	*/
	class ExtHolidayReturn extends ModelDB{
	var $tableName = 'ext_holiday_return';

		function joinMemberBase(){
			$this->addJoins(array('model' => 'member/Base'));
		}

		function addDataReturn($mID, $date, $time){
			$arrayData['member_base_id'] = $mID;
			$arrayData['dateTime'] = $date .' ' . $time;

			$this->commit($arrayData);
		}

	}
?>