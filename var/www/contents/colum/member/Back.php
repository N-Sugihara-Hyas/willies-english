<?php

	$arrayColum = array(
		'cource_base_id' => array(
			'name' => 'コース',
			'type' => 'select',
			'list' => '1',
			'search' => true,
			'data' => 'CourceBase',
		),
		'cource_style_id' => array(
			'name' => 'プラン',
			'type' => 'select',
			'list' => '1',
			'data' => 'CourceStyle',
		),
		'member_base_id' => array(
			'name' => '該当生徒ID',
			'type' => 'text',
			'list' => '0',
		),
		'cource_schedule_id' => array(
			'name' => '対応レッスンスケジュール',
			'type' => 'select',
			'data' => 'Schedule',
			'list' => '1',
		),
		'timeStart' => array(
			'name' => '時間　（開始）',
			'type' => 'select',
			'data' => 'Time',
			'list' => '0',
		),
		'timeEnd' => array(
			'name' => '時間　（終了）',
			'type' => 'select',
			'data' => 'Time',
			'list' => '0',
		),
		'take_base_id' => array(
			'name' => '担当の講師',
			'type' => 'select',
			'data' => 'TakeBase',
			'list' => '1',
		),		
	);

	$self->parent->updateData = function() use($self){
	};

	$self->parent->updateDataOut = function() use($self){
		if (!empty($this->arrayInput['id'])){
			$this->arrayInput['member_base_id'] = $this->arrayInput['id'];


			$this->arrayInput['timeStart'] = date('H:i', strtotime($this->arrayInput['timeStart']));
			$this->arrayInput['timeEnd'] = date('H:i', strtotime($this->arrayInput['timeEnd']));

		}
		
		
	};
?>