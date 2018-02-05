<?php

	addModel('ModelDB');

	/*
	*	休日
	*/
	class ExtHoliday extends ModelDB{
	var $tableName = 'ext_holiday';

		/*
		*	範囲内に休日があれば取得
		*/
		function getHolidayArea($date){			
			$this->addQuery('dateStart LIKE', $date . '%');
			
			return $this->getData()->getData();
		}
	
		
		/*
		*	コミット時の処理
		*/
		function commit($arrayData=array()){
			$TakeReserve = $this->getModel('take/Reserve');
			$MemberBase = $this->getModel('member/Base');
			$ExtHolidayReturn = $this->getModel('ext/HolidayReturn');
			
	
			$uid = parent::commit($this->arrayData);
			
			for ($i = strtotime($this->arrayData['dateStart']); $i <= strtotime($this->arrayData['dateEnd']); ){				
				$date = date('Y-m-d', $i);
				$time = date('H:i:s', $i);
				
				$arrayTakeReserver = $TakeReserve->getScheduleDate($date, $time)->getData();
				
				if ($arrayTakeReserver){
					$ExtHolidayReturn->addDataReturn($arrayTakeReserver['member_base_id'], $date, $time);
					
					
					//メールも飛ばす
					$this->addModelTool('Mail');
					$this->arrayMail['domain'] = $this->arraySetting['domain'];
					$this->arrayData['date'] = $date . ' ' . $time;
					//$this->mailSend(3, array($arrayMember['email']));

					$TakeReserve->addQuery('id', $arrayTakeReserver['id']);
					$TakeReserve->delData();
				}
					
					
				//全講師の予約をブロック
				$TakeBase = $this->getModel('take/Base');
				$arrayTakeBase = $TakeBase->getData()->getDataAll();
				
				
				foreach ($arrayTakeBase as $item){
					$TakeReserve->delDataTime(0, $date, $time, 25, 0, $item['id'], -1);
					$TakeReserve->addDataTime(0, $date, $time, 25, 0, $item['id'], -1);
				}
				
				$i += 1800;
			}
			
			return $uid;
		}
		
		/*
			*	対象講師の勤務日の取得
			*/
		function getWork($dateStart, $dateEnd, $objTake, $type=1){
			
			$timeStart = strtotime($dateStart);
			
			if ($timeStart < strtotime($objTake['created'])){
				$timeStart = strtotime($objTake['created']);
			}

			$weekday = 0;
			$weekend = 0;
			
			for ($i = $timeStart; $i <= strtotime($dateEnd); $i+=3600*24){
				$w = date('w', $i);
				
				$this->addQuery('dateStart LIKE', date('Y-m-d', $i) . '%');
				$objHoliday = $this->getData()->getData();
				
				if (!$objHoliday){				
					if (($w == 0) || ($w == 6)){
						if ($type == 1){
							$weekend++;
						}else{
							$weekend+=40;
						}
					}else{
						if ($type == 1){
							$weekday++;					
						}else{
							$weekday+=40;
						}
					}
				}
			}
			
			return array($weekday, $weekend);
			
		}
	}
?>