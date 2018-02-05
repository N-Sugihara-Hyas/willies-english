<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		$this->addModel(array('take/Salary', 'take/Base', 'take/Schedule', 'take/Salary', 'cource/Style') );

		//共通処理
		$this->getCommon();

		//講師の情報
		$this->TakeBase->addQuery('isView', 1);
		$this->TakeBase->order = 'id ASC';
		$arrayTake = $this->TakeBase->getData()->getDataAll();
		

		
		
		$arrayType = $this->CourceStyle->getBasicStyle();
		
	

			
		if (isset($this->arrayAll['arrayInput'])){
			foreach ($this->arrayAll['arrayInput'] as $key => $objData){	
				$this->TakeSalary->setDataEasy('rate', $key, $objData);
			}
		}

		foreach ($arrayTake as $objTake){
			$arrayData[$objTake['id']] = $this->TakeSalary->getDateTake('rate', $objTake);
		}
		

		$this->set('arrayData', $arrayData);			
		$this->set('arrayType', $arrayType);		
		
?>