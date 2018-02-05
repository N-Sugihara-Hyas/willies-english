<?php

	/*
	*	休日の場合の振替ポイント
	*/
	$this->addModel(array('ext/HolidayReturn', 'member/Base', 'member/Point'));


	//7日後設定
	$day = 0;
	$date = date('Y-m-d', time());// + ($day * 3600 * 24));

	$this->ExtHolidayReturn->target = '*,ext_holiday_return.*';
	$this->ExtHolidayReturn->joinMemberBase();
	$this->ExtHolidayReturn->group = 'member_base_id,dateTime';
	$this->ExtHolidayReturn->addQuery('dateTime LIKE', $date . '%');
	$this->ExtHolidayReturn->addQuery('member_base.timeStart IS NOT NULL');
	$this->ExtHolidayReturn->addQuery('member_base.take_base_id<>0');


	$dbGet = $this->ExtHolidayReturn->getData();

	while ($item = $dbGet->getData()){
		if ($item['state'] == 3){
			//予約が存在する場合は振替ポイント
			$arrayMember = $this->MemberBase->getDataUID($item['member_base_id'])->getData();
			$arrayMember['countReturn']++;
			$this->MemberBase->commit($arrayMember);



			$arrayPoint['id'] = $item['member_base_id'];
			$arrayPoint['countReturn'] = 1;

			$this->MemberPoint->addPoint($arrayPoint);
		}

		$this->ExtHolidayReturn->addQuery('id', $item['id']);
		$this->ExtHolidayReturn->delData();
	}
	exit();

?>