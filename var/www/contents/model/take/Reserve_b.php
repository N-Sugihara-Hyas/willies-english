<?php

	addModel('ModelDB');

	/*
	*	講師の予約状況のクラス
	*/
	class TakeReserve extends ModelDB{
	var $tableName = 'take_reserve';
	var $arrayType = array('体験レッスン', 'レギュラーレッスン', '振替レッスン', 'グループ音読レッスン');
	var $order = 'date ASC,take_reserve.timeStart ASC';
	var $mode=0;
	var $countDaily = 5;
	var $isB = false;
	var $isOK = false;		//getDataDate一つでも予約があるか？
	var $isMemberCheck = true;	//メンバーのスケジュールもチェックするか？
	var $arrayPayTotal = array();
	
	//var $group = 'take_reserve.timeStart';
	
		function joinMemberDaily($dateTime){
			$this->addJoins(array('model' => 'member/Daily', 'on' => "take_reserve.take_base_id=member_daily.take_base_id AND member_daily.datetime='" . $dateTime . "'"));
		}

		/*
		*	講師情報のジョイント
		*/
		function joinTakeBase(){
			$this->addJoins(
				array('model' => 'take/Base')
			);
		}
		/*
		*	コーススタイル情報のジョイント
		*/
		function joinCourceStyle(){
			$this->addJoins(
				array('model' => 'cource/Style')
			);
		}

		/*
		*	生徒の情報のジョイント
		*/
		function joinMemberBase(){
			$this->addJoins(
				array('model' => 'member/Base')
			);
		}


		/*
		*	担当制のスケジュールの追加
		*	@params $date $csID 曜日ID $time 時間 $weekTime 受講時間 $tID 講師ID $type 追加する種類 $trial トライアルか？
		*/
		function addDataWeek($date, $mID, $cID, $cshID, $time, $weekTime, $tID, $type=1, $trial=0, $csID=0){
			$arrayWeek = $this->getFunctionData('Schedule');
			$arrayWeek = $arrayWeek[$cshID];
			$arrayWeek = explode(',', $arrayWeek['week']);

			//$dateNow = strtotime($date) - (3600 * 24);
			$dateNow = strtotime($date);
			$dateLimit = $dateNow + (3600 * 24 * $this->arraySetting['maxSchedule']);


			$this->addLiblary('inoutput/Date');

			$ExtHolidayReturn = $this->getModel('ext/HolidayReturn');
			$ExtHolidayReturn->addQuery('member_base_id', $mID);
			$ExtHolidayReturn->delData();

			$count = 0 ;
			$countTrial = 0;
			
			while ($dateNow < $dateLimit){
				foreach ($arrayWeek as $item){

					$week =  date('w', $dateNow);


					//スケジュールの追加
					if ($item == $week){
						$date = date('Y-m-d', $dateNow);

						if ($this->getDataTime($cID, $date, $time, $weekTime, $type, $tID)){
							$this->addDataTime($mID, $date, $time, $weekTime, $csID, $tID, $type, $trial);
							
							if ($trial){
								$countTrial++;
							}
						}else{
							//休日用にポイントを付けるリスト(体験は振替にならない)
							if (!$trial){
								$ExtHolidayReturn = $this->getModel('ext/HolidayReturn');
								$ExtHolidayReturn->addDataReturn($mID, $date, $time);
							}

						}


						$count++;
					}

				}
				$dateNow+=3600 * 24;

				//体験は初日のみ(曜日の場合は各曜日で2回)
				if ($trial){
					if ($countTrial >= 2){
						$trial = 0;
					}
				}
			}

		}

		/*
		*	担当制のスケジュールの削除
		*	@params $mID メンバーID $date 日付 $time 時間 $weekTime 受講時間 $tID 講師ID $type 種類 $trial トライアルか？
		*/
		function delDataTime($mID, $date, $time, $weekTime, $tID, $type=1, $trial=0){

			$id = $this->getID($mID, $date, $time, $tID, $type);

			$this->addQuery('id', $id);
			$this->delData();
		}

		/*
		*	担当制のスケジュールの追加
		*	@params $mID メンバーID $date 日付 $time 時間 $weekTime 受講時間 $tID 講師ID $type 種類 $trial トライアルか？
		*/
		function addDataTime($mID, $date, $time, $weekTime, $csID, $tID, $type=1, $trial=0){

			$arrayResult['id'] = $this->getID($mID, $date, $time, $tID, $type);


			$arrayResult['member_base_id'] = $mID;
			$arrayResult['date'] = $date;
			$arrayResult['timeStart'] = $time;
			$arrayResult['timeEnd'] = date('H:i:s', strtotime($time) + ($weekTime * 60));

			$arrayResult['cource_style_id'] = $csID;
			$arrayResult['take_base_id'] = $tID;
			$arrayResult['week'] = date('w', strtotime($date));

			$arrayResult['type'] = $type;

			if (!$trial){$trial = 0;}

			$arrayResult['isTrial'] = $trial;

			$this->addData($arrayResult);
			
			//同様のものをAllにも追加
			$TakeReserveAll = $this->getModel('take/ReserveAll');
			$TakeReserveAll->addData($arrayResult);
		}

		function getID($mID, $date, $time, $tID, $type=0){
			$id = $tID . '-' . $mID . '-' . str_replace('-', '', $date) . '-' . $time . '-' . $type;
			$id = str_replace(':','', $id);

			//9-1-20140506-060000-1
			//9-0-20140506-060000-0

			return $id;
		}

		/*
		*	担当制のスケジュールの追加
		*	@params $mID メンバーID $date 日付 $time 時間 $tID 講師ID $type 指定タイプ
		*/
		function removeDataTime($mID=0, $date, $time,  $tID=0, $type=null){

			if ($mID){
				$this->addQuery('member_base_id', $mID);
			}

			$this->addQuery('date', $date);
			$this->addQuery('timeStart', $time);

			if ($tID){
				$this->addQuery('take_base_id', $tID);
			}
			if ($type != null){
				$this->addQuery('type', $type);
			}


			$this->delData();

		}


		/*
		*	自分のスケジュールの取得
		*	@paramse $mID 該当ユーザーの指定 $isHistory 過去も取得
		*/
		function getScheduleMy($mID, $isHistory=false){
			//自分が予約した講師のスケジュールを取得
			$this->joinTakeBase();
			$this->target = 'take_base.*,take_reserve.*';

			$this->addQuery('take_reserve.member_base_id', $mID);
			
			if (!$isHistory){
				$this->addQuery('CONCAT(date, " ",timeStart) >=', date('Y-m-d H:i:s'));
				//$this->addQuery('CONCAT(date) >=', date('Y-m-d'));
			}

			$arrayData = $this->getData();


			$MemberCancel = $this->getModel('member/Cancel');

			$arrayResult = array();

			//予約の前日の２１時までしかキャンセルは不可
			$i = 0;
			while ($item = $arrayData->getData()){
				$arrayResult[$i] = $item;

				$arrayResult[$i]['isCancel'] = $MemberCancel->isCancel($item['member_base_id'], $item);

				$i++;
			}

 			return $arrayResult;
		}

		/*
		*	対象の講師の情報取得
		*	@paramse $tID 該当講師の指定 $dateStart 開始日　$dateEnd 終了日
		*/
		function getScheduleTake($tID=0, $dateStart='', $dateEnd=''){
			$this->joinMemberBase();
			$this->order = 'member_base_id ASC';

			if ($tID){
				$this->addQuery($this->tableName . '.take_base_id', $tID);
			}

			if ($dateStart){
				$this->addQuery($this->tableName . '.date >=', $dateStart);
			}

			if ($dateEnd){
				$this->addQuery($this->tableName . '.date <=', $dateEnd);
			}


			return $this->getData();
		}

		/*
		*	対象の日時の予約情報取得
		*	@paramse $date 開始日 time 時間
		*/
		function getScheduleDate($date='', $time){
			if ($date){
				$this->addQuery('take_reserve.date', $date);
				$this->addQuery('take_reserve.timeStart', $time);
			}
			/*if ($dateEnd){
				$this->addQuery('take_reserve.date <=', $dateEnd);
			}*/

			$this->addQuery('type<>', 0);
			$this->addQuery('type<>', -1);


			return $this->getData();
		}



		/*
		*	対象の講師の就労時間の取得
		*	@paramse $tID 該当講師の指定
		*/
		function getDataTakeTime($tID, $dateStart='', $dateEnd='', $type=''){
			$this->target = 'SUM(TIME_TO_SEC(timeStart)) as timeStart,SUM(TIME_TO_SEC(timeEnd)) as timeEnd';
			$this->group = 'take_base_id';

			$this->addQuery('take_base_id', $tID);

			if ($type){
				$this->addQuery('type', $type);
			}else{
				$this->addQuery('type <>', 0);
			}

			if ($dateStart){
				$this->addQuery('take_reserve.date >=', $dateStart);
			}

			if ($dateEnd){
				$this->addQuery('take_reserve.date <=', $dateEnd);
			}

			$arrayResult = $this->getData()->getData();

			return (($arrayResult['timeEnd'] - $arrayResult['timeStart']) / 60) / 25;
		}


		/*
		*	指定した日付の予約できる人間を取得
		*	@params $cID コースID $date 日付又は曜日で指定したい場合 $skypeTime 受講時間 $type タイプ$tID 講師のID
		*/
		function getDataDate($cID, $date, $skypeTime, $type, $tID=0){
			$arrayResult = array();
			$i = $this->arraySetting['timeStart'];

			$start = '00';
						
			while ($i <= $this->arraySetting['timeEnd']){
				if ($i < 10){$hour = '0' . $i;}else{$hour = $i;}

				$time = $hour . ':' . $start . ':00';

				$arrayTake = $this->getDataTime($cID, $date, $time, $skypeTime, $type,  $tID);

				if ($arrayTake){
					$arrayResult[$time] = $arrayTake;
					$this->isOK = true;
				}

				if (($skypeTime == 25) && ($start == '00')){
					$judg = true;
					$start = $skypeTime + 5;
				}else{
					$start = '00';
					$i++;
				}
			}
						
			return $arrayResult;

		}

		/*
		*	指定した日時の予約できる人間を取得
		*	@params $cID コースID $date 日付又は曜日で指定したい場合 $skypeTime 受講時間, $type $tID 講師のID
		*/
		function getDataTime($cID, $date, $time, $skypeTime, $type, $tID=0){
			$timeLoad = time() + (3600 * 24 * $this->arraySetting['maxReserve']);

			if (is_array($date)){
				$dateTarget = strtotime($date[0] . ' 00:00:00');	
			}else{
				$dateTarget = strtotime($date . ' 00:00:00');
			}
			$arrayResult = array();


			if (isset($this->isScheduleLimit)){

				//指定期日以上の予約は入れられない
				if ($dateTarget > $timeLoad){
					return false;
				}

					
				//予約は3時間以内の物を入れられる
				$d = date('d');
				$h = date('H') + 3;
				$h2= date('H', strtotime($time));
				
				if ($h > 23){
					$h-= 23;
					$d++;
				}
								
				$dateOK = date('Y-m') . '-' . $d;

				if (strtotime($dateOK . $h . ':00:00') > strtotime($date . $h2 . ':00:00')){
					return false;
				}
			}

			$TakeBase = $this->getModel('take/Base');

			//講師の指定
			if ($tID){
				$TakeBase->addQuery('take_base.id', $tID);
			}

			if ($type == 3){
				//音読予約の場合
				$TakeBase->mode = 1;
			}



			if ($cID){
				$arrayTake = $TakeBase->getDataCource($cID);


				if ($type == 3){
					$CourceBase = $this->getModel('cource/BaseDaily');
				}else{
					$CourceBase = $this->getModel('cource/Base');
				}

				$arrayCourceBase = $CourceBase->getDataUID($cID)->getData();

				//if ($type != 2){
					//コースによって可能時間が違う
					$timeTarget = strtotime($time);
					$timeStart = strtotime($arrayCourceBase['timeStart'] . ':00');
					$timeEnd = strtotime($arrayCourceBase['timeEnd'] . ':00');
					$timeStart2 = strtotime($arrayCourceBase['timeStart2'] . ':00');
					$timeEnd2 = strtotime($arrayCourceBase['timeEnd2'] . ':00');
					$timeStart3 = strtotime($arrayCourceBase['timeStart3'] . ':00');
					$timeEnd3 = strtotime($arrayCourceBase['timeEnd3'] . ':00');


					if ((($timeStart > $timeTarget) || ($timeEnd < $timeTarget)) &&
							(($timeStart2 > $timeTarget) || ($timeEnd2 < $timeTarget)) &&
							(($timeStart3 > $timeTarget) || ($timeEnd3 < $timeTarget))){
						return array();
					}
				//}
			}else{
				$arrayTake = $TakeBase->getData()->getDataAll();
			}

			$MemberBase = $this->getModel('member/Base');
			$arraySchedule = $MemberBase->getFunctionData('Schedule');

			if (is_array($date)){
				$week = date('w', strtotime($date[0]));
				
				if (!empty($date[1])){
					$week2 = date('w', strtotime($date[1]));
				}
			}else{
				$week = date('w', strtotime($date));
			}
			
			foreach ($arraySchedule as $weeks){
				if (strpos($weeks['week'], $week) !== FALSE){
					$scheduleID = $weeks['id'];
				}
			}


			
			$arrayWeek = $MemberBase->getWeek($week);
			if (isset($week2) ){
				$arrayWeek = array_merge($arrayWeek, $MemberBase->getWeek($week2));							
			}
			
			
			$arrayMember = array();

			$this->target = '*,take_reserve.*,take_reserve.week as weekSch';
			$this->group = 'take_reserve.take_base_id,take_reserve.type';

			$this->addQuery('(0');
			foreach ($arrayTake as $item){
				$this->addQuery('OR take_reserve.take_base_id', $item['id']);
			}
			$this->addQuery('OR 0)');
			
			$this->addQuery('(1');

			
			//同一日時と講師で、定期レッスン者がいる
			$arrayMember =array();
			if ($type == 1){
				if ($this->isMemberCheck){
					if (empty($this->isB)){
						$MemberBase->addQuery('timeStart', $time);

						$MemberBase->addQuery('(0');
						foreach ($arrayTake as $item){
							$MemberBase->addQuery('OR take_base_id', $item['id']);
						}
						$MemberBase->addQuery('OR 0)');

						/*if (isset($scheduleID) ){
							$MemberBase->addQuery('cource_schedule_id', $scheduleID);
						}*/


						if ($arrayWeek){
							$MemberBase->addQuery('(0');
							foreach ($arrayWeek as $itemSch){
								$MemberBase->addQuery('OR cource_schedule_id', $itemSch);
							}
							$MemberBase->addQuery('OR 0)');
						}
	
						$MemberBase->addQuery('state <>', 2);
						$MemberBase->addQuery('state <>', 9);
	
						$dbGetMmber = $MemberBase->getData();
			
						while ($itemMember = $dbGetMmber->getData()){
							$arrayMember[$itemMember['take_base_id']] = $itemMember;
						}
					}
				}
			}
			
		

			//複数指定の場合
			if (is_array($date)){
				$this->addQuery('(0');

				foreach ($date as $item2){
					$this->addQuery('OR date', $item2);
				}


				$this->addQuery('OR 0)');
				//print_r($date);
			}else{
				$this->addQuery('date', $date);
			}

			$this->addQuery('(1');
			$this->addQuery('(1');
			$this->addQuery('timeStart>=', $time);
			$this->addQuery('timeStart<=', date('H:i:s', strtotime('1981-05-01 ' . ' ' . $time) + (60 * $skypeTime)));
			$this->addQuery('1)');


			if ($skypeTime == 25){
				$h = date('H', strtotime('1981-05-01 ' . ' ' . $time));
				$this->addQuery('OR timeEnd', $h . ':50');
			}
			$this->addQuery('1)');
			$this->addQuery('1)');

			$dbReserve = $this->getData();
			$arrayReserve = array();
			while ($itemReserve = $dbReserve->getData()){
				$arrayReserve[$itemReserve['take_base_id']] = $itemReserve;
			}
			
			
			foreach ($arrayTake as $item){
				if (!$arrayJudg = getVar($arrayReserve, $item['id']) ){				
					$item['timeStart'] = date('H:i:s', strtotime('1981-01-01 ' . $time));
					$item['timeEnd'] = date('H:i:s', strtotime('1981-05-01 ' . ' ' . $time) + (60 * $skypeTime));

					if (empty($arrayMember[$item['id']])){
						$arrayResult[$item['id']] =  $item;
						$arrayResult[$item['id']]['take_base_id'] =  $item['id'];
					}else{


					}
				}
				
				$this->arrayJudg = $arrayJudg;
			}
			

			return $arrayResult;
		}

		/*
		*	体験を指定よりも長く受けてる人で規定日の人の取得
		*/
		function getTryoutOver(){
			//$date = date('Y-m-d', time() + 3600 * 24);
			$date = date('Y-m-d', time());

			$this->joinMemberBase();

			$this->target = 'take_reserve.*';
			$this->order = 'take_reserve.date ASC';


			$this->addQuery('date', $date);
			$this->addQuery('isPay <>', 1);
			$this->addQuery('state <>', 10);
			$this->addQuery('isTrial', 0);
			$this->addQuery('type', 1);

			return $this->getData();
		}

		function getRecode($mid){
			$this->joinTakeBase();
			$this->order = 'date DESC';
			$this->addQuery('date <', date('Y-m-d'));
			$this->addQuery('take_reserve.member_base_id', $mid);

			return $this->getData();
		}
				
		function getCounter($timeStart, $timeEnd, $objTake){
			$TakeSchedule = $this->getModel('take/Schedule');

			if (!isset($this->arrayTypeCourse)){
				$CourceStyle = $this->getModel('cource/Style');
				$this->arrayTypeCourse = $CourceStyle->getCounterStyle();
			}
				
			$arrayPay = array();

			foreach ($this->arrayTypeCourse as $type => $item2){
				if (!isset($this->arrayPayTotal[$type])){
					$arrayPay[$type] = 0;
					$this->arrayPayTotal[$type] = 0;
				}
			}	

			for ($i = $timeStart; $i <= $timeEnd;){
					$total = 0;
					$totalTime = 0;
					$date = date('Y-m-d', $i);
		
		
					foreach ($this->arrayTypeCourse as $type => $objView){
						if (isset($objView['time'])){
							$this->joinCourceStyle();
							$this->addQuery('date', $date);
							$this->addQuery('take_base_id', $objTake['id']);
							$this->group = 'timeStart';
							$this->addQuery('styleType', $type);
			
							$arrayPay[$date][$type] = $this->getData()->getCount();
							$this->arrayPayTotal[$type]+= $arrayPay[$date][$type];
							$arrayPay[$type]+=$arrayPay[$date][$type];
							
							$total+=$arrayPay[$date][$type];
							if ($arrayPay[$date][$type] ){
								$totalTime+=(intval($objView['time']) / 50) * $arrayPay[$date][$type];
							}
						}
					}					
					$this->addQuery('date', $date);
					$this->addQuery('take_base_id', $objTake['id']);
					$this->addQuery('type', 4);
					$this->group = 'timeStart';
					
					$arrayPay[$date]['Other'] = $this->getData()->getCount();
					$this->arrayPayTotal['Other']+= $arrayPay[$date]['Other'];
					$arrayPay['Other']+=$arrayPay[$date]['Other'];
					
					$total+= $arrayPay[$date]['Other'];
					$totalTime+= $arrayPay[$date]['Other'];
		
					//勤務数取得
					$dbGet = $TakeSchedule->getWork($objTake['id'], array(date('w', $i)));
		
					$arraySch = $dbGet->getDataAll();
					$countSch = $dbGet->getCount();
		
					$countLesson = 0;
		
					//まずはレギュラースケジュールの実行数を算出
					if ($arraySch){
						$this->joinCourceStyle();
						$this->group = 'timeStart';
		
						foreach ($arraySch as $itemSch){
							$this->addQuery('OR (1');
							$this->addQuery('take_base_id', $objTake['id']);
							$this->addQuery('date', $date);
							$this->addQuery('type > 0');
							$this->addQuery('timeStart', $itemSch['time']);
							$this->addQuery('1)');
						}
						$dbGet2 = $this->getData();
		
						while ($itemRev = $dbGet2->getData()){
							$countLesson+=intval($itemRev['weekTime']) / 50;
						}
					}
		
					//超過
					$arrayPay[$date]['AdditionalWork'] = $totalTime - ($countSch - ($countSch - $countLesson));		
					if ($arrayPay[$date]['AdditionalWork'] < 0){$arrayPay[$date]['AdditionalWork'] = 0;}
		
					$this->arrayPayTotal['AdditionalWork']+= $arrayPay[$date]['AdditionalWork'];
					$arrayPay['AdditionalWork']+=$arrayPay[$date]['AdditionalWork'];

					//休日の取得
					$this->group = 'timeStart';
					$this->addQuery('date', $date);
					$this->addQuery('take_base_id', $objTake['id']);
					$this->addQuery('type', -2);
					$arrayPay[$date]['Absence'] = $this->getData()->getCount() / 2;
		
					$this->arrayPayTotal['Absence']+= $arrayPay[$date]['Absence'];
					$arrayPay['Absence']+=$arrayPay[$date]['Absence'];

		
		
				$i+=3600*24;
			}
			
			return $arrayPay;
		}

		/*
			*	トライアルレッスンの取得
			*/
		function getTrical($mid='', $tid='', $isPay=false, $dateStart='',$dateEnd=''){
			$this->joinTakeBase();
			$this->target = 'take_base.*,take_reserve.*';
			$this->order = 'take_reserve.date DESC';
			$this->addQuery('isTrial', 1);
			
			if ($mid){
				$this->addQuery('member_base_id', $mid);
			}
			if ($tid){
				$this->addQuery($this->tableName . '.take_base_id', $tid);
			}			
			
			if ($dateStart){
				$this->addQuery('take_reserve.created >=', $dateStart);
			}
			if ($dateEnd){
				$this->addQuery('take_reserve.created <=', $dateEnd);
			}
			
			if ($isPay){
				$this->joinMemberBase();
				$this->addQuery('datePay IS NOT NULL');
			}
			
			
			return $this->getData();
		}
	}
?>