<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		$this->addModel(array('take/Salary', 'take/SalaryData', 'take/SalaryDate', 'take/Base', 'take/Reserve') );

		//共通処理
		$this->getCommon();

		//講師の情報
		$this->TakeBase->addQuery('isView', 1);
		$this->TakeBase->order = 'id ASC';
		$arrayTake = $this->TakeBase->getData()->getDataAll();
		
		$this->set('arrayTake', $arrayTake);
								
		list($dateStart, $dateEnd) = $this->TakeSalary->getDate();

		//％データの保存と取得
		if (isset($this->arrayAll['parsent'])){		
			$this->TakeSalaryData->setDataEasy('itParsent', $this->arrayAll['parsent']);
		}
		$itParsent = $this->TakeSalaryData->getDataEasy('itParsent')->getData();
		$this->set('parsent', $itParsent['value']);
		
		//％取得
		$arrayBonus = array();
		foreach ($arrayTake as $objTake){										
			$arrayBonus[$objTake['id']] = $this->TakeSalaryDate->getInternet($dateStart, $dateEnd, $objTake, getVar($this->arrayAll, 'arrayInput'));			
		}
		

				


		
		$this->set('arrayRate', $arrayRate);
		$this->set('arrayData', $arrayData);								
		$this->set('arrayBonus', $arrayBonus);			
		$this->set('arraySalary', $arraySalary);
		
?>