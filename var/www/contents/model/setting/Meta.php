<?php

	addModel('ModelMeta');

	/*
	*	全体のメタのクラス
	*/
	class SettingMeta extends ModelMeta{
	var $tableName = 'setting_meta';
	
		
		/*
		*	コーススタイルの連結
		*/
		function joinCourceStyle(){
			$this->addJoins(
				array('model' => 'cource/Style', 'on' => 'cource_style.id=setting_meta.value')
			);
		}

		/*
		*	講師のIDから、該当のコーススタイルの情報を取得
		*	@params $cID コースID
		＊@return コーススタイルの情報
		*/
		function getDataCource($tID){
			$this->joinCourceStyle();
			
			$this->order = 'cource_style.styleType ASC';
			$this->addQuery('setting_meta.id', 'arrayCourceStyle_' . $tID);
			return $this->getData()->getDataAll();
		}

		/*
		*	コーススタイルのIDから、該当の予約可能曜日の情報を取得
		*	@params $cID コーススタイルID
		＊@return 可能な曜日の情報
		*/
		function getDataSchedule($cID){
			$this->order = 'cast(value as unsigned) ASC';
			$this->addQuery('setting_meta.id', 'weekSchedule_' . $cID);
			$arraySchedule = $this->getData()->getDataAll();
			
			foreach ($arraySchedule as $key => $item){
				$value = $item['value'];
				$arraySchedule[$key]['id'] = $arraySchedule[$key]['value'];
				$arraySchedule[$key]['value'] = $this->getFunctionDataOwn('Schedule', $value);
			}

			return $arraySchedule;
		}
		
		function sortWeek($arraySch){
			$arrayType[base64_encode('日')] = 1;
			$arrayType[base64_encode('月')] = 2;
			$arrayType[base64_encode('火')] = 3;
			$arrayType[base64_encode('水')] = 4;
			$arrayType[base64_encode('木')] = 5;
			$arrayType[base64_encode('金')] = 6;
			$arrayType[base64_encode('土')] = 7;
			
			$arrayResult = array();

			foreach ($arraySch as $objWeek){
				$countValue = mb_strlen($objWeek['value'], 'UTF-8');
				
				$countSort = '';

				for ($i = 0; $i < $countValue; $i++){
					$value = mb_substr($objWeek['value'], $i, 1, 'UTF-8');

					if (isset($arrayType[base64_encode($value)])){					
						$countSort.= $arrayType[base64_encode($value)];
					}				
					
				}
				$arrayResult[$countSort] = $objWeek;														
			}
					
			ksort($arrayResult);
			
			return $arrayResult;
		}
		
		function changeWeekSort($arrayWeek){
			$arrayType[base64_encode('日')] = 0;
			$arrayType[base64_encode('月')] = 1;
			$arrayType[base64_encode('火')] = 2;
			$arrayType[base64_encode('水')] = 3;
			$arrayType[base64_encode('木')] = 4;
			$arrayType[base64_encode('金')] = 5;
			$arrayType[base64_encode('土')] = 6;
			$isWeek = false;
				
			$arrayResult = array();
			foreach ($arrayWeek as $objWeek){
				if (isset($arrayType[base64_encode($objWeek['value'])])){
					
					$arrayResult[$arrayType[base64_encode($objWeek['value'])]] = $objWeek;					
					$isWeek = true;
				}				
			}
			
			if (!$isWeek){
				return $arrayWeek;				
			}else{
				ksort ($arrayResult);
				return $arrayResult;
			}
		}

	}

?>