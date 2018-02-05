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
		
		$this->set('arrayTake', $arrayTake);
				
		list($dateStart, $dateEnd) = $this->TakeSalary->getDate();		

	
		//レート取得
		$dbGet = $this->TakeSalary->getDataEasy('rate');
		
		$arrayRate = array();
		while ($objData = $dbGet->getData()){
			$arrayRate[$objData['take_base_id']] = $this->TakeSalary->decodeJson($objData);
		}	
		
			

		//予約から入会があった体験学習の取得
		$arrayBonus = array();
		foreach ($arrayTake as $objTake){
			$arrayData[$objTake['id']] = $this->TakeSalaryDate->getBounus($dateStart, $dateEnd, $objTake, getVar($this->arrayAll, 'arrayInput'));			
		}
		
		
		$this->set('arrayRate', $arrayRate);
		$this->set('arrayData', $arrayData);								
		$this->set('arrayBonus', $arrayBonus);			
		$this->set('arraySalary', $arraySalary);
		
?>