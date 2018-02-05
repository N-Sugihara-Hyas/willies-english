<?php

	addModel('ModelDB');

	/*
	*	講師のクラス
	*/
	class TakeSalary extends ModelDB{
	var $tableName = 'take_salary';


		function getDate(){
			$TakeSalaryData = $this->getModel('take/SalaryData');
			
			$dateStart = $TakeSalaryData->getDataEasyValue('dateStart');
			$dateEnd = $TakeSalaryData->getDataEasyValue('dateEnd');
			
			return array($dateStart, $dateEnd);
			
		}		
		
		function setDataEasy($type, $tid, $objData){
			$check = '';
			/*foreach ($objData as $value){
				$check.=$value;
			}*/
			
			//if ($check){
				$objResult = $this->getDataEasy($type, $tid, false)->getData();
				
				$objResult['type'] = $type;									
				$objResult['take_base_id'] = $tid;
				$objResult['body'] = json_encode($objData);
	
				$this->commit($objResult);
			//}
		}
		
		function getDataEasy($type, $tid=0, $data=''){

			$this->addQuery('type', $type);
			
			if ($tid){
				$this->addQuery('take_base_id', $tid);
			}
			

			return $this->getData();
		}
		
		function decodeJson($objData){
			$objJson = json_decode($objData['body'], true);
			
				
			foreach ($objJson as $key => $value){
				$objData[$key] = $value;
			}
			
			return $objData;
		}
		
		function getDateTake($key, $objTake){
			$objResult = $this->getDataEasy($key, $objTake['id'])->getData();
			
			if ($objResult){
				$objResult = $this->decodeJson($objResult);
			}
			
			$objResult['objTake'] = $objTake;
			
			
			return $objResult;
		}
		
		//データ更新
		function setDataTake($key, $objResult, $tid, $arrayInput){
			$isSave = false;
							
			foreach ($arrayInput[$tid] as $keyDate => $itemDate){
				if (strlen($itemDate)){
					if ($itemDate != $objResult[$keyDate]){
						$isSave = true;
						$objResult[$keyDate] = $itemDate;
					}
				}
			}
			
			if ($isSave){
				$this->setDataEasy($key, $tid, $arrayInput[$tid]);
			}
						
			return $objResult;
		}
		
		//2.BasicInfomation
		function getWorkTime($objTake, $dateStart, $dateEnd, $arrayInput=array()){			
			
			$TakeSchedule = $this->getModel('take/Schedule');

			$objResult['weekdayHr'] = $TakeSchedule->getWorkArray($objTake['id'], $dateStart, $dateEnd, 1);
			$objResult['weekendHr'] = $TakeSchedule->getWorkArray($objTake['id'], $dateStart, $dateEnd, 2);

			$objResult2 = $this->getDateTake('weekSchedule', $objTake);
			
			if (!$objResult2){$objResult2 = $objResult;}
			
			if ($arrayInput){
				//データ更新
				$objResult2 = $this->setDataTake('weekSchedule', $objResult2, $objTake['id'], $arrayInput);
			}
			
			if (!empty($objResult2['weekdayHr'])){
				$objResult['weekdayHr'] = $objResult2['weekdayHr'];			
			}
			if (!empty($objResult2['weekendHr'])){
				$objResult['weekendHr'] = $objResult2['weekendHr'];			
			}
			
			
			
			$objResult['objTake'] = $objTake;
			
			return $objResult;
		}

		
		//8. Other		
		function getOther($objTake, $arrayInput=array()){
			$objResult = $this->getDateTake('other', $objTake);
			
			if (!isset($objResult['ocount'])){$objResult['ocount'] = '0';}
			if (!isset($objResult['memo'])){$objResult['memo'] = '';}
			
			if ($arrayInput){
				$objResult = $this->setDataTake('other', $objResult, $objTake['id'], $arrayInput);
			}
			
			return $objResult;
		}
		
		//総合値
		function getTotal($objTake, $objData){
			if (!isset($this->TakeReserve)){
				$this->TakeReserve = $this->getModel('take/Reserve');
				$this->TakeSalaryData = $this->getModel('take/SalaryData');
				
				$CourceStyle = $this->getModel('cource/Style');
				$this->arrayTypeCounter = $CourceStyle->getCounterStyle();

				$this->pcr = $this->TakeSalaryData->getDataEasyValue('pcr');
			}
			
			$objDataResult['total'] = 0;
			
			//Basicサラリーの計算
			$objDataResult['basic'] = ($objData['weekday'] * $objData['weekdayHr']) + ($objData['weekend'] * $objData['weekendHr']);
			$objDataResult['basic']+= $objData['arrayCounter']['AdditionalWork'];
			$objDataResult['basic']-= $objData['arrayCounter']['Absence'];			
			$objDataResult['basic'] = intval($objDataResult['basic']) * intval(getVar($objData['arrayRate'], 'BasicSalaryRate'));
						
			
			$objDataResult['total']+=$objDataResult['basic'];			
			
			
			//総合の計算
			foreach ($this->arrayTypeCounter as $type => $objView){								
				if (!empty($objView['time'])){
					$count = $objData['arrayCounter'][$type];
					
					$objDataResult['total']+=$objDataResult[$type] = $count  * intval(getVar($objData['arrayRate'], $type));				
				}
			}
			


			$objDataResult['total']+=$objData['ntotal'];			
			$objDataResult['total']+=$objData['ipeso'];						
			$objDataResult['total']+=$objData['rtotal'];									
			$objDataResult['total']+=$objData['ocount'];									
			
			$objDataResult['totalYen'] = intval($objDataResult['total'] / $this->pcr);
			
			return $objDataResult;
		}		
		
	}
?>