<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		$this->addModel(array('take/Salary', 'take/Base', 'take/Reserve', 'take/SalaryDate') );

		//共通処理
		$this->getCommon();

		//講師の情報
		$this->TakeBase->addQuery('isView', 1);
		$this->TakeBase->order = 'id ASC';
		$arrayTake = $this->TakeBase->getData()->getDataAll();

		foreach ($arrayTake as $objTake){
			$arrayData[$objTake['id']]['objTake'] = $objTake;
		}
				
		$this->set('arrayTake', $arrayTake);
		
		list($dateStart, $dateEnd) = $this->TakeSalary->getDate();
						
		$arrayPay = array();
		foreach ($arrayTake as $objTake){
			$arrayPay[$objTake['id']] = $this->TakeSalaryDate->getCounter($dateStart, $dateEnd, $objTake, getVar($this->arrayAll, 'arrayInput'));

			$arrayPay[$objTake['id']]['objTake'] = $objTake;
		}
		
		$this->set('arrayData', $arrayData);								
		$this->set('arrayPay', $arrayPay);			
		$this->set('arrayTypeCourse', $this->TakeSalaryDate->TakeReserve->arrayTypeCourse);		
		$this->set('arraySalary', $arraySalary);
		
?>