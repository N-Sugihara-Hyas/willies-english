<?php

class ValidateTakeReserve extends Validate{
	var $validate = array(
		'date' => array(
			array(
				'type' => 'NonSpace',
				'message' => 'not entered'
			),
			array(
				'type' => 'checkOK',
				'message' => 'no schedule'
			),
		),
		'member_base_id' => array(
			array(
				'type' => 'checkMember',
				'message' => 'no Member'
			),
		),

	);
	
	
	function checkOK($strCheck, $arrayError, $key){
		$cID = 0;
		
		if ($this->arrayInput['type'] == '2'){
			$cID = $this->arrayInput['cource_base_id'];
		}
		if ($this->arrayInput['type'] == '3'){
			$TakeSchedule->mode = 1;
			$cID = $this->arrayInput['cource_base_daily_id'];
		}
		
		$this->TakeReserve->isB = true;
		/*if (!$this->TakeReserve->getDataTime($cID, $this->arrayInput['date'], $this->arrayInput['timeStart'], $this->arrayInput['skypeTime'], $this->arrayInput['take_base_id'])){
			return $arrayError['message'];
		}*/
	}

	function checkMember($strCheck, $arrayError, $key){
		if ($this->arrayInput['type'] == '4'){return;}
		if (!$strCheck){return $arrayError['message'];}

		$MemberBase = $this->TakeReserve->getModel('member/Base');
		
		if (!$MemberBase->getDataUID($strCheck)->getData()){
			return $arrayError['message'];
		}
	}
	
}

?>
