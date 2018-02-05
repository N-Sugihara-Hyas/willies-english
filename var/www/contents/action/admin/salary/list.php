<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		$this->addModel(array('take/Salary', 'take/Base', 'take/SalaryData','take/SalaryDate') );

		//共通処理
		$this->getCommon();

		//講師の情報
		$this->TakeBase->addQuery('isView', 1);
		$this->TakeBase->order = 'id ASC';
		$arrayTake = $this->TakeBase->getData()->getDataAll();

				
		$this->set('arrayTake', $arrayTake);
		
		$arrayType = array('dateSalary', 'dateStart', 'dateEnd', 'pcr');

		//日付等の情報保存
		if ($this->arrayPost){
			foreach ($arrayType as $item){
				$this->TakeSalaryData->setDataEasy($item, $this->arrayAll[$item]);
			}
		}
		
		//日付等の情報取得
		$objDate = array();
		foreach ($arrayType as $item){
			$objDate[$item] = $this->TakeSalaryData->getDataEasyValue($item);	
			$this->set($item, $objDate[$item]);	
		}

		//勤務日の取得	
		$weekday = 0;
		$weekend = 0;		
		foreach ($arrayTake as $objTake){
			$arraySalary[$objTake['id']] = $this->TakeSalaryDate->getWorkDay($objTake, $objDate['dateStart'], $objDate['dateEnd'], getVar($this->arrayAll, 'arrayInput'));


			//上に出す奴			
			if ($arraySalary[$objTake['id']]['weekday'] > $weekday){$weekday = $arraySalary[$objTake['id']]['weekday'];}
			if ($arraySalary[$objTake['id']]['weekend'] > $weekend){$weekend = $arraySalary[$objTake['id']]['weekend'];}
		}
		
		$this->set('weekday', $weekday);		
		$this->set('weekend', $weekend);				
		$this->set('arrayType', $arrayType);		
		$this->set('arraySalary', $arraySalary);
		
?>