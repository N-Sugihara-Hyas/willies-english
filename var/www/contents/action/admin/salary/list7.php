<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		$this->addModel(array('take/SalaryDate','take/Salary', 'take/Base', 'take/Reserve', 'ext/Holiday') );

		//共通処理
		$this->getCommon();

		//講師の情報
		$this->TakeBase->addQuery('isView', 1);
		$this->TakeBase->order = 'id ASC';
		$arrayTake = $this->TakeBase->getData()->getDataAll();
		
		$this->set('arrayTake', $arrayTake);
		
		foreach ($arrayTake as $objTake){
			$arrayData[$objTake['id']]['objTake'] = $objTake;
		}
		
		list($dateStart, $dateEnd) = $this->TakeSalary->getDate();
		
		//講師情報の取得
		$arrayBonus = array();
		foreach ($arrayTake as $objTake){					
			$arrayBonus[$objTake['id']] = $this->TakeSalaryDate->getReferral($dateStart, $dateEnd, $objTake, getVar($this->arrayAll, 'arrayInput'));
		}
		
		$this->set('arrayBonus', $arrayBonus);
		$this->set('arrayRate', $arrayRate);
		$this->set('arrayData', $arrayData);								
		$this->set('arraySalary', $arraySalary);
		
?>