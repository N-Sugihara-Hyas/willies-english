<?php

	addModel('ModelDB');

	/*
	*	講師のクラス
	*/
	class TakeBase extends ModelDB{
	var $tableName = 'take_base';
	var $tableNameSession = 'take_session';
	var $loginID = 'take_base_id';
	var $dateLastLogin = 'dateLastLogin';
	var $mode = 0;			//0は通常、1はグループ音読レッスン

		function joinTakeSchedule(){
			$this->addJoins(array('model' => 'take/Schedule', 'on' => "take_base.id=take_schedule.take_base_id"));
		}
		function joinTakeReserve(){
			$this->addJoins(array('model' => 'take/Reserve', 'on' => "take_base.id=take_reserve.take_base_id"));
		}

		function joinCourceBase(){
			$this->addJoins(array('model' => 'setting/Meta', 'on' => "setting_meta.id=concat('arrayTakeCource_', take_base.id)"));
			$this->addJoins(array('model' => 'cource/Base', 'on' => "cource_base.id=setting_meta.value"));
		}
		
		function joinCourceBaseDaily(){
			$this->addJoins(array('model' => 'setting/Meta', 'on' => "setting_meta.id=concat('arrayTakeCourceDaily_', take_base.id)"));
			$this->addJoins(array('model' => 'cource/BaseDaily', 'on' => "cource_base_daily.id=setting_meta.value"));
		}

		/*
		*	指定したコースを選択している講師の一覧の取得
		*	@params $cID コースID
		*/
		function getDataCource($cID){
			$this->target = '*,take_base.*';

			if ($this->mode){
				$this->joinCourceBaseDaily();
				$this->addQuery('cource_base_daily.id', $cID);
			}else{
				$this->joinCourceBase();
				$this->addQuery('cource_base.id', $cID);
			}
			
			return $this->getData()->getDataAll();
		}

		/*
		*	給与情報の取得条件設定
		*	@params $arrayTake 講師情報
		*	@return 給与情報
		*/
		function getAllowance($arrayTake, $dateStart='', $dateEnd=''){

			$TakeReserve = $this->getModel('take/Reserve');
			$TakeShedule = $this->getModel('take/Schedule');
			$MemberBase = $this->getModel('member/Base');

			$arrayResult['countSheduleTime'] = $TakeShedule->getDataTakeTime($arrayTake['id'], $dateStart, $dateEnd);
			$arrayResult['countReserveTime'] = $TakeReserve->getDataTakeTime($arrayTake['id'], $dateStart, $dateEnd);
			$arrayResult['countNormal'] = $TakeReserve->getDataTakeTime($arrayTake['id'], $dateStart, $dateEnd, 1);
			$arrayResult['countReturn'] = $TakeReserve->getDataTakeTime($arrayTake['id'], $dateStart, $dateEnd, 2);
			$arrayResult['countDaily'] = $TakeReserve->getDataTakeTime($arrayTake['id'], $dateStart, $dateEnd, 3);
			$arrayResult['countOther'] = $TakeReserve->getDataTakeTime($arrayTake['id'], $dateStart, $dateEnd, 4);
			$arrayResult['countMember'] = $MemberBase->getDataTake($arrayTake['id'])->getCount();
			$arrayResult['countMemberFow'] = 0;
			
						
			return $arrayResult;
		}
	}
?>