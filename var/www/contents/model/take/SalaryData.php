<?php

	addModel('ModelDB');

	/*
	*	講師のクラス
	*/
	class TakeSalaryData extends ModelDB{
	var $tableName = 'take_salary_data';

		function getDataEasy($key){
			$this->addQuery('type', $key);
			
			return $this->getData();
		}

		function getDataEasyValue($key){
			$objData = $this->getDataEasy($key)->getData();
			
			return $objData['value'];
		}
		
		function setDataEasy($key, $value){
			if (strlen($value)){
				$objData = $this->getDataEasy($key)->getData();
	
				$objData['type'] = $key;
				$objData['value'] = $value;
					
				$this->commit($objData);
			}
		}
	}
?>