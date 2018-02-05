<?php

	addModel('ModelDB');

	/*
	*	講師のスケジュールのクラス
	*/
	class TakeSchedule extends ModelDB{
	var $tableName = 'take_schedule';
	var $order = 'time ASC';
	var $group = '*';
	
	
		/*
		*	講師の連結
		*/
		function joinTakeBase(){
			$this->addJoins(
				array('model' => 'take/Base')
			);
		}

		function joinCourceBase(){
			$this->joinTakeBase();

			$this->addJoins(array('model' => 'setting/Meta', 'on' => "setting_meta.id=concat('arrayTakeCource_', take_base.id)"));
			$this->addJoins(array('model' => 'cource/Base', 'on' => "cource_base.id=setting_meta.value"));
		}
		function joinCourceBaseDaily(){
			$this->joinTakeBase();

			$this->addJoins(array('model' => 'setting/Meta', 'on' => "setting_meta.id=concat('arrayTakeCourceDaily_', take_base.id)"));
			$this->addJoins(array('model' => 'cource/BaseDaily', 'on' => "cource_base_daily.id=setting_meta.value"));
		}
		
		function joinMemberDaily($dateTime){
			$this->addJoins(array('model' => 'member/Daily', 'on' => "take_schedule.take_base_id=member_daily.take_base_id AND member_daily.datetime='" . $dateTime . "'"));
		}

		/*
		*	指定講師のスケジュールの取得
		*	@params $id 講師のID
		*/
		function getDataTake($id){
			$this->addQuery('take_base_id', $id);
			$this->addQuery('type', 1);
			$dbGet = $this->getData();

			$arrayResult = array();
			while ($item = $dbGet->getData() ){
				list($time1, $time2, $time3) = explode(':', $item['time']);
				$time = $time1 . ':' . $time2;
				$arrayResult[$item['week']][$time] = 1;
			}

			return $arrayResult;
		}

		/*
		*	指定講師のスケジュールの更新
		*	@params $id 講師のID $arrayData スケジュールの配列データ
		*/
		function reflash($id, $arrayData){
			//一度対象講師のスケジュールをまっさらに
			$this->addQuery('take_base_id', $id);
			$this->delData();

			$arrayAdd['modified'] = $arrayAdd['created'] = date('Y-m-d H:i:s');
			$arrayAdd['take_base_id'] = $id;
						
			//配列のデータを追加
			if ($arrayData){
				foreach ($arrayData as $key => $item){
					foreach ($item as $key2 => $item2){
						$arrayAdd['week'] = $key;
						$arrayAdd['time'] = $key2;
						$arrayAdd['type'] = $item2;
						$this->addData($arrayAdd);
					}
				}
			}
		}
		
		
		/*
		*	指定した講師とデータで三ヶ月間のブロックの再生成
		*/
		function reflashBlock($tid=0){
			$dateNow = date('Y-m-d');
			$timeNow = time();
			$timeLoad = time() + (3600 * 24 * $this->arraySetting['maxSchedule']);

			$ExtHoliday = $this->getModel('ext/Holiday');
						
			//一時削除
			$TakeReserve = $this->getModel('take/Reserve');
			$TakeBase = $this->getModel('take/Base');
			
			if ($tid){
				$TakeReserve->addQuery('take_base_id', $tid);
				$TakeBase->addQuery('id', $tid);
			}
			$arrayTake = $TakeBase->getData()->getDataAll();


			$TakeReserve->addQuery('(0');
			$TakeReserve->addQuery('OR type', 0);
			$TakeReserve->addQuery('OR type', -1);
			$TakeReserve->addQuery('OR 0)');
			$TakeReserve->delData();
			
			$arrayTiem = $this->getArrayTime();
			
			//再計算
			for ($i = $timeNow; $i <= $timeLoad;){
				$w = date('w', $i);
				$date = date('Y-m-d', $i);


				if ($tid){
					$this->addQuery('take_base_id', $tid);
				}
				$this->addQuery('type', 0);
				$this->addQuery('week', $w);
				
				$dbGet = $this->getData();
				
					
				$arrayTime = $ExtHoliday->getHolidayArea($date);
				
				if ($arrayTime){
					$time1 = strtotime($arrayTime['dateStart']);
					$time2 = strtotime($arrayTime['dateEnd']);
					
					for ($timeNow = $time1; $timeNow <= $time2;){
						foreach ($arrayTake as $itemTake){
							$timeNowDate = date('H:i:s', $timeNow);
							
							
							$TakeReserve->delDataTime(0, $date, $timeNowDate, 25, 0, $itemTake['id'], -1);
							$TakeReserve->addDataTime(0, $date, $timeNowDate, 25, 0, $itemTake['id'], -1);
						}
						
						$timeNow+= 30 * 60;
					}
				}
				
				
				
				while ($item = $dbGet->getData()){
					$TakeReserve->delDataTime(0, $date, $item['time'], 25, 0, $item['take_base_id'], 0);
					$TakeReserve->addDataTime(0, $date, $item['time'], 25, 0, $item['take_base_id'], 0);
				}
				
				$i += 3600 * 24;
			}
		}


		/*
		*	予定できる時間を全て取得
		*	@return 時間
		*/
		function getArrayTime($weekTime=25){
			$count = 0;

			for ($i = $this->arraySetting['timeStart']; $i <= $this->arraySetting['timeEnd']; $i++){
				if (($i < 1) || ($i >= 5)){
				
					$number = intval($i);
					if ($number < 10){$hour = '0' . $number;}else{$hour = $number;}
					
					$time = $hour . ':00';

					$arrayResult[$time]['id'] = $time;
					$arrayResult[$time]['value'] = $time;

					if ($weekTime < 30){
						$time = $hour . ':30';

						$arrayResult[$time]['id'] = $time;
						$arrayResult[$time]['value'] = $time;
					}
				}
				
				$count++;
			}

			return $arrayResult;
		}

		/*
		*	指定した曜日のIDから全ての日付を配列で取得
		*	@params $date 現在日 $id 曜日のID $isStrong 強制取得
		*	@return 配列データ
		*/
		function getWeekData($date, $id, $cID=0, $isStrong=false){
			echo 'UU';
			
			$this->addLiblary('inoutput/Date');

			$arraySchedule = $this->getFunctionData('Schedule');
			$arraySchedule = $arraySchedule[$id];

			$w = date('w', strtotime($date));
			$arrayWeek = explode(',', $arraySchedule['week']);
			$arrayDate[0] = $date;

			$TakeReserve = $this->getModel('take/Reserve');
			foreach ($arrayWeek as $item){
				if ($w != $item){
					$dateResult = InoutputDate::getNextWeekDate($item, $date);
					if (($TakeReserve->getDataDate($cID, $dateResult, 50, 1)){
						array_push($arrayDate, InoutputDate::getNextWeekDate($item, $date));
					}
				}
			}

			return $arrayDate;
		}
		
		/*
		*	対象の講師の就労予定時間の取得
		*	@paramse $tID 該当講師の指定
		*/
		function getDataTakeTime($tID, $dateStart='', $dateEnd=''){
			$count = 0;
			//時間計算
			for ($i = strtotime($dateStart); $i <= strtotime($dateEnd);){
				$this->addQuery('take_base_id', $tID);
				$this->addQuery('week', date('w', $i));
				$count+=$this->getData()->getCount();
				
				$i+=(3600*24);
			}
			
			return $count;
		}

		function reflashUpdateZone($tID){
			$TakeUpdateZone = $this->getModel('take/UpdateZone');

			//一度消去
			$TakeUpdateZone->addQuery('take_base_id', $tID);
			$TakeUpdateZone->delData();

			$this->order = 'week ASC,time ASC';

			if ($tID){
				$this->addQuery('take_base_id', $tID);
			}

			$dbGet = $this->getData();

			$type = 0;
			while ($item = $dbGet->getData()){
				//5時前はスケジュールが無いため、自動的に休むことになる。
				if ($item['time'] == '05:00:00'){
					$type = 0;
				}

				if (($item['type'] != $type) && ($item['type'])){
					$flag = true;

					//ゾーンの保存
					$arrayData['take_base_id'] = $tID;
					$arrayData['week'] = $item['week'];
					$arrayData['time'] = $item['time'];

					$TakeUpdateZone->commit($arrayData);
				}

				$type = $item['type'];
			}
		}

	}
?>