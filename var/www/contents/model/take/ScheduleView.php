<?php

	addModel('Model');

	/*
	*	講師のスケジュールを表示させるクラス
	*/
	class TakeScheduleView extends Model{

		function setView($arrayAll, $mode='none', $types='default', $cID='', $skypeTime=''){
			//モデル情報の読み込み
			$TakeBase = $this->getModel('take/Base');
			$TakeBase->order = 'take_base.id ASC';

			if (empty($arrayAll['allView'])){
				$TakeBase->addQuery('isView', 1);
			}

			$TakeSchedule = $this->getModel('take/Schedule');
			
			if ($mode == 'all'){
				$TakeReserve = $this->getModel('take/ReserveAll');				
			}else{
				$TakeReserve = $this->getModel('take/Reserve');
			}
			
			//講師の選択条件の取得
			$takeName = getVar($arrayAll, 'takeName');

			//日時
			if (!empty($arrayAll['dateStart'])){
				$dateStart = $arrayAll['dateStart'];
			}else{
				$dateStart = date('Y-m-d');
			}
			if (!empty($arrayAll['dateEnd'])){
				$dateEnd = $arrayAll['dateEnd'];
			}else{
				$dateEnd = date('Y-m-d');
			}
			
			

			//一日プラスする
			$dateEnd2 = date('Y-m-d', strtotime($dateEnd) + (3600 * 24));
	
			if ($takeName){
				//講師の検索が合った場合
				$TakeBase->addQuery('nickname', $takeName);
				$arrayTakeBase[0] = $TakeBase->getData()->getData();
				
			}else{
				//検索が無い場合は全ての講師の情報取得
				$arrayTakeBase = $TakeBase->getData()->getDataAll();
			}
			
			//スケジュール情報取得
			$arrayResult = array();
			if ($types=='type2'){
				$defaultTake = $arrayTakeBase[0];
				$arrayTakeBase = array();
				$arrayTakeBase[0] = $defaultTake;
				$takeName = $arrayTakeBase[0]['nickname'];
				
				for ($i = strtotime($dateStart); $i <= strtotime($dateEnd); $i+=3600*24){
					$arrayReserver = $TakeReserve->getDataDate($cID, date('Y-m-d', $i), $skypeTime, 1, $arrayTakeBase[0]['id']);
					
					foreach ($arrayReserver as $keyTake => $objTake){
						foreach ($objTake as $keyReserve => $objReserve){
							$arrayResult[$keyReserve][date('Y-m-d', $i)][$keyTake] = $objReserve;
						}
					}
				}

			}else{
				foreach ($arrayTakeBase as $item){
					$TakeReserve->target = '*,' . $TakeReserve->tableName . '.*';
					$dbGet = $TakeReserve->getScheduleTake($item['id'], $dateStart, $dateEnd2);

					while ($item2 = $dbGet->getData()){
						$arrayResult[$item2['take_base_id']][$item2['date']][$item2['timeStart']] = $item2;
					}
				}				
				
			}

			//日付の間の配列の取得
			$timeStart = strtotime($dateStart);
			$timeEnd = strtotime($dateEnd);

			for ($i = $timeStart; $i <= $timeEnd;){
				$dateNow = date('Y-m-d', $i);
				$arrayDate[$dateNow] = $dateNow;
				$i+= 3600 * 24;
			}

			$arraySet['my'] =  urlencode(substr($_SERVER['REQUEST_URI'], 1));
			$arraySet['arrayTime'] =  $TakeSchedule->getArrayTime(50);	
			$arraySet['arrayDate'] =  $arrayDate;
			$arraySet['countDate'] =  count($arrayDate);
			$arraySet['dateStart'] =  $dateStart;
			$arraySet['dateEnd'] =  $dateEnd;
			$arraySet['arrayResult'] =  $arrayResult;
			$arraySet['arrayTakeBase'] =  $arrayTakeBase;
			$arraySet['takeName'] =  $takeName;

			return $arraySet;
		}
	}