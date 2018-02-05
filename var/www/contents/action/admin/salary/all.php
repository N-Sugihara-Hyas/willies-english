<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		$this->addModel(array('take/Salary', 'take/SalaryData', 'take/SalaryDate', 'take/Base', 'take/Reserve', 'ext/Holiday', 'take/Schedule', 'cource/Style') );
		
		
		//共通処理
		$this->getCommon();

		//講師の情報
		$this->TakeBase->addQuery('isView', 1);
		$this->TakeBase->order = 'id ASC';
		$arrayTake = $this->TakeBase->getData()->getDataAll();
		
		$this->set('arrayTake', $arrayTake);
		
		$arrayData = array();
						
		list($dateStart, $dateEnd) = $this->TakeSalary->getDate();

		$arrayType = $this->CourceStyle->getBasicStyle();
		$arrayTypeCounter = $this->CourceStyle->getCounterStyle();
		
		foreach ($arrayTake as $objTake){
			$arrayData[$objTake['id']] = $this->TakeSalaryDate->getWorkDay($objTake, $dateStart, $dateEnd);			//1
			$arrayData[$objTake['id']] = array_merge($arrayData[$objTake['id']], $this->TakeSalary->getWorkTime($objTake, $dateStart, $dateEnd));		//2
			$arrayData[$objTake['id']]['arrayRate'] = $this->TakeSalary->getDateTake('rate', $objTake);	//3
			$arrayData[$objTake['id']]['arrayCounter'] = $this->TakeSalaryDate->getCounter($dateStart, $dateEnd, $objTake);		//4
			$arrayData[$objTake['id']] = array_merge($arrayData[$objTake['id']], $this->TakeSalaryDate->getBounus($dateStart, $dateEnd, $objTake));	//5
			$arrayData[$objTake['id']] = array_merge($arrayData[$objTake['id']], $this->TakeSalaryDate->getInternet($dateStart, $dateEnd, $objTake));		//6		
			$arrayData[$objTake['id']] = array_merge($arrayData[$objTake['id']], $this->TakeSalaryDate->getReferral($dateStart, $dateEnd, $objTake));	//7
			$arrayData[$objTake['id']] = array_merge($arrayData[$objTake['id']], $this->TakeSalary->getOther($objTake));	//8			
			
			//総合値の計算
			$arrayData[$objTake['id']]['arrayTotal'] = $this->TakeSalary->getTotal($objTake, $arrayData[$objTake['id']]);
			
		}
		

		$this->set('arrayType', $arrayType);			
		$this->set('arrayTypeCounter', $arrayTypeCounter);			
		$this->set('arrayData', $arrayData);
		
?>