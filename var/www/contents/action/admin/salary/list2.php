<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		$this->addModel(array('take/Salary', 'take/Base', 'take/Schedule', 'take/Salary') );

		//共通処理
		$this->getCommon();

		//講師の情報
		$this->TakeBase->addQuery('isView', 1);
		$this->TakeBase->order = 'id ASC';
		$arrayTake = $this->TakeBase->getData()->getDataAll();
		
		$this->set('arrayTake', $arrayTake);

				
				
		list($dateStart, $dateEnd) = $this->TakeSalary->getDate();

		
		//金額の保存情報の取得		
		foreach ($arrayTake as $objTake){
			$arraySalary[$objTake['id']] = $this->TakeSalary->getWorkTime($objTake, $dateStart, $dateEnd, getVar($this->arrayAll, 'arrayInput'));			
		}


		$this->set('arrayData', $arrayData);			
		$this->set('arrayType', $arrayType);		
		$this->set('arraySalary', $arraySalary);
		
?>