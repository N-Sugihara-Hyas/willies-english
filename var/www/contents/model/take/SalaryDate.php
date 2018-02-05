<?php

	addModel('ModelDB');

	/*
	*	講師のクラス
	*/
	class TakeSalaryDate extends ModelDB{
	var $tableName = 'take_salary_date';


		
		function setDataEasy($type, $tid, $objData){
			$check = '';
			foreach ($objData as $value){
				$check.=$value;
			}
			
			$model = $this->getModel('take/Salary');
			
			if (strlen($check)){
				$objResult = $this->getDataEasy($type, $tid, false)->getData();
				
				list($dateStart, $dateEnd) = $model->getDate();
	
				$objResult['type'] = $type;									
				$objResult['date'] = $dateStart;
				$objResult['take_base_id'] = $tid;
				$objResult['body'] = json_encode($objData);
	
	
				$this->commit($objResult);
			}
		}
		
		function getDataEasy($type, $tid=0, $data=''){
			$model = $this->getModel('take/Salary');

			list($dateStart, $dateEnd) = $model->getDate();

			$this->addQuery('type', $type);
			
			if ($tid){
				$this->addQuery('take_base_id', $tid);
			}
			
			$this->addQuery('date', $dateStart);

			return $this->getData();
		}
		
		function decodeJson($objData){
			$objJson = json_decode($objData['body'], true);
			
				
			foreach ($objJson as $key => $value){
				$objData[$key] = $value;
			}
			
			return $objData;
		}
		
		//データの取得の講師特化方
		function getDataTake($key, $objResult, $tid){
			$TakeSalaryDate = $this->getModel('take/SalaryDate');
			
			//データ取得できていない場合は取得
			if (!isset($this->arrayDate[$key])){
				$dbGet = $TakeSalaryDate->getDataEasy($key);

				while ($objData = $dbGet->getData()){
					$this->arrayDate[$key][$objData['take_base_id']] = $TakeSalaryDate->decodeJson($objData);
				}
			}	
			
			//取得したデータをマージ
			if (isset($this->arrayDate[$key][$tid]) ){				
				//$objResult = array_merge($objResult, $this->arrayDate[$key][$tid]);
				
				foreach ($this->arrayDate[$key][$tid] as $key2 => $item2){
					$objResult[$key2] = $item2;
				}
			}
						
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
		
		//1.BasicInfomation
		function getWorkDay($objTake, $dateStart, $dateEnd, $arrayInput=array()){			
			$ExtHoliday = $this->getModel('ext/Holiday');
			
			list($objResult['weekday'], $objResult['weekend']) = $ExtHoliday->getWork($dateStart, $dateEnd, $objTake);
			$objResult = $this->getDataTake('monthSchedule', $objResult, $objTake['id']);

			if ($arrayInput){
				//データ更新
				$objResult = $this->setDataTake('monthSchedule', $objResult, $objTake['id'], $arrayInput);
			}
			
			$objResult['objTake'] = $objTake;
			
			return $objResult;
		}


		//4.Class you had
		function getCounter($dateStart, $dateEnd, $objTake, $arrayInput=array()){		

			if (!isset($this->TakeReserve)){
				$this->TakeReserve = $this->getModel('take/Reserve');
			}
			
			
			$objResult = $this->TakeReserve->getCounter(strtotime($dateStart), strtotime($dateEnd), $objTake);
			
			
			$objResult = $this->getDataTake('counter', $objResult, $objTake['id']);
				
				if ($arrayInput){
				//データ更新
				$objResult = $this->setDataTake('counter', $objResult, $objTake['id'], $arrayInput);
			}
			
			$objResult['objTake'] = $objTake;
			
			return $objResult;
		}
		
		//5.New Student Bounus
		function getBounus($dateStart, $dateEnd, $objTake, $arrayInput=array()){
			if ((!isset($this->TakeReserve)) || (!isset($this->TakeSalary))){
				$this->TakeReserve = $this->getModel('take/Reserve');
				$this->TakeSalary = $this->getModel('take/Salary');
			}
				
			$objResult['ncount'] = $this->TakeReserve->getTrical('', $objTake['id'], true, $dateStart, $dateEnd)->getCount() /  2;

			$this->TakeReserve->group = 'member_base_id';
			$objResult['arrayTrial'] = $this->TakeReserve->getTrical('', $objTake['id'], true, $dateStart, $dateEnd)->getDataAll();
			$objResult['nmember'] = '';

			foreach ($objResult['arrayTrial'] as $objMember){$objResult['nmember'].= $objMember['member_base_id']. ',';}

			$objResult = $this->getDataTake('bonus', $objResult, $objTake['id']);
				
			if ($arrayInput){
				//データ更新
				$objResult = $this->setDataTake('bonus', $objResult, $objTake['id'], $arrayInput);
			}

			$objRate = $this->TakeSalary->getDateTake('rate', $objTake);
			
			$objResult['ntotal'] = getVar($objRate, 'BonusNewStudent') * $objResult['ncount'];
			$objResult['objTake'] = $objTake;

			return $objResult;
		}

		//6. Internet Allowance
		function getInternet($dateStart, $dateEnd, $objTake, $arrayInput=array()){
			$Salary = $this->getModel('take/Salary');
			
			$objDay = $this->getWorkDay($objTake, $dateStart, $dateEnd);
			$objTime = $Salary->getWorkTime($objTake, $dateStart, $dateEnd);

			
			if (!isset($this->TakeSalaryData)){				
				$this->TakeSalaryData = $this->getModel('take/SalaryData');
				$this->TakeSalary = $this->getModel('take/Salary');
				$this->itParsent = $this->TakeSalaryData->getDataEasyValue('itParsent');
			}
			
			$objHoliday = $this->getCounter($dateStart, $dateEnd, $objTake);

			
			if (empty($objHoliday['Absence'])){
				$parsent = 0;
			}else{
				$parsent =  $objHoliday['Absence'] / (($objDay['weekday'] * $objTime['weekdayHr']) + ($objDay['weekend'] * $objTime['weekendHr']));
			}
			
			$parsent = $parsent * 100;
			$parsent = round($parsent, 1);
	
			$objResult['icount'] = $parsent;
			
			$arrayRate = $this->TakeSalary->getDateTake('rate', $objTake);

			$objResult = $this->getDataTake('internetAllowance', $objResult, $objTake['id']);

			if ($arrayInput){
				//データ更新
				$objResult = $this->setDataTake('internetAllowance', $objResult, $objTake['id'], $arrayInput);
			}

			
			if ($this->itParsent > $objResult['icount']){
				$objResult['ipeso'] = intval(getVar($arrayRate, 'InternetAllowance'));
			}else{
				$objResult['ipeso'] = 0;
			}
				
				
			
			$objResult['objTake'] = $objTake;


			return $objResult;
		}
		
		//7. Referral Bonus
		function getReferral($dateStart, $dateEnd, $objTake, $arrayInput=array()){
			$objResult = array();
			$objResult = $this->getDataTake('referralBonus', $objResult, $objTake['id']);

			if (!isset($this->TakeSalary)){				
				$this->TakeSalary = $this->getModel('take/Salary');
			}
							
			if ($arrayInput){
				//データ更新
				$objResult = $this->setDataTake('referralBonus', $objResult, $objTake['id'], $arrayInput);
			}
			
			if (!isset($objResult['rcount'])){
				$objResult['rcount'] = 0;
			}
			
			$objRate = $this->TakeSalary->getDateTake('rate', $objTake);
			$objResult['rtotal'] = $objResult['rcount'] * intval(getVar($objRate, 'ReferralBonus'));
			
			$objResult['objTake'] = $objTake;
						
			return $objResult;
		}
	}
?>