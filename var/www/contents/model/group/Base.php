<?php

	addModel('ModelDB');

	/*
	*	コースのクラス
	*/
	class GroupBase extends ModelDB{
	var $tableName = 'group_base';
	var $order = 'group_base.sort ASC';
	
		function joinTakeBase(){
			$this->addJoins(array('model' => 'take/Base'));
		}
		function getLevel(){
			$this->group = 'level';
			
			return $this->getData();
		}
		
		//スケジュールから予約が取れるところを取得
		function getDate($dateStart, $dateEnd, $gID=0){
			$timeStart = strtotime($dateStart);
			$timeEnd = strtotime($dateEnd);
			
			$arrayResult = array();
			
			
			for ($i = $timeStart; $i <= $timeEnd; $i+=3600*24){
				$this->addQuery('dateOpen <=', date('Y-m-d'));
				$this->addQuery('week LIKE', '%'. date('w', $i) . ',%');
				
				//時間の場合は時間制限も入れる
				$timeLimit = $timeEnd - $timeStart;
				if ($timeLimit < 3600 * 24){
					$this->addQuery('timeStart >=', date('H:i', $timeStart));
					$this->addQuery('timeStart <=', date('H:i', $timeEnd));
				}
				
				$arrayData =$this->getData()->getDataAll();
				
				if ($arrayData){
					foreach ($arrayData as $item2){
						$key = date('Ymd', $i) . str_replace(':', '', $item2['timeStart']);
						$arrayResult[$key][$item2['id']] = $item2;
					}					
				}
			}
			
			
			return $arrayResult;
		}

		//予約の追加
		function addReserve($dateStart, $dateEnd, $countMax, $gid, $tid){			
			$arrayData['dateStart'] = $dateStart;
			$arrayData['dateEnd'] = $dateEnd;
			$arrayData['group_base_id'] = $gid;
			$arrayData['count'] = 0;
			$arrayData['countMax'] = $countMax;
			$arrayData['take_base_id'] = $tid;
			
			$rid = $this->commit($arrayData);
			
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

	}
?>