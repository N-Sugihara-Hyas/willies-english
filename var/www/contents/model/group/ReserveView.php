<?php

	addModel('Model');

	/*
	*	講師のスケジュールを表示させるクラス
	*/
	class GroupReserveView extends Model{

		function setView($arrayAll, $mode='none'){
			//モデル情報の読み込み
			$TakeBase = $this->getModel('take/Base');
			$TakeBase->order = 'take_base.id ASC';

			if (empty($arrayAll['allView'])){
				$TakeBase->addQuery('isView', 1);
			}

			$CourceGroup = $this->getModel('group/Base');
			
			if ($mode == 'all'){
				$GroupReserve = $this->getModel('group/ReserveAll');				
			}else{
				$GroupReserve = $this->getModel('group/Reserve');
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
			foreach ($arrayTakeBase as $item){
				$GroupReserve->target = '*,' . $GroupReserve->tableName . '.*';
				
				$dbGet = $GroupReserve->getScheduleTake($item['id'], str_replace('-', '', $dateStart) . '0000', str_replace('-', '',$dateEnd2) . '2350');
				
				while ($item = $dbGet->getData()){										
					$arrayResult[$item['take_base_id']][date('Y-m-d', strtotime($item['dateStart']))][date('H:i', strtotime($item['dateStart'])) . ':00'] = $item;
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
			$arraySet['arrayTime'] =  $CourceGroup->getArrayTime(50);	
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