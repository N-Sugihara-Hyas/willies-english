<?php

	addModel('ModelDB');

	/*
	*	コーススタイルのクラス
	*/
	class CourceStyle extends ModelDB{
	var $tableName = 'cource_style';
	var $order = 'styleType ASC';

		function getStyle($arrayType=array()){
			$this->order = 'styleType ASC';
			$this->group = 'styleType';
			
			$dbGet = $this->getData();
			
			while ($objStyle = $dbGet->getData()){
				$arrayType[$objStyle['styleType']]['view']=  'Class ' . $objStyle['styleType']  . '(' . $objStyle['weekTime'] . 'min' . ')';
				$arrayType[$objStyle['styleType']]['time']=  $objStyle['weekTime'];
			}
			
			return $arrayType;
		}
		
		function getBasicStyle(){
			$arrayType['BasicSalaryRate']['view'] = 'BasicSalaryRate';
			
			$arrayType = $this->getStyle($arrayType);

			$arrayType['BonusNewStudent']['view'] = 'BonusNewStudent';
			$arrayType['InternetAllowance']['view'] = 'InternetAllowance';
			$arrayType['ReferralBonus']['view'] = 'ReferralBonus';
						
			return $arrayType;
		}
	
		function getCounterStyle(){	
			$arrayType = $this->getStyle();	


			$arrayType['Other']['view'] = 'Other';
			$arrayType['AdditionalWork']['view'] = 'Additional Work';
			$arrayType['Absence']['view'] = 'Absence';

			
			return $arrayType;
		}
		
	}
?>