<?php


	$self->parent->changeData = function($arrayData, $arrayKey, $str, $resultName){
		$arrayData[$resultName] = '';
				
		foreach ($arrayKey as $item){
			$arrayData[$resultName].= $arrayData[$item] . $str;
			unset($arrayData[$item]);
		}
		
		$arrayData[$resultName] = substr($arrayData[$resultName], 0, strlen($arrayData[$resultName]) - 1);
		
		return $arrayData;
	};	
	
	$self->parent->changeReturn = function($arrayData, $arrayKey, $str, $resultName){
		
		if (strpos($arrayData[$resultName], $str) !== FALSE){
			$arrayResult = explode($str,$arrayData[$resultName]);
		}
						
		foreach ($arrayKey as $key => $item){
			if (isset($arrayResult[$key])){
				$arrayData[$item] = $arrayResult[$key];
			}
		}
		
		
		return $arrayData;
	};	

?>