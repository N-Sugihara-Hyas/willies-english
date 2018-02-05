<?php
	require_once 'TakeBase.php';
	
		/*
		 * コースの取得
		 */
		function getSelectTakeBaseAll($model){
			$arrayResult['0'] = array('id' => '0', 'value' => 'teacher all');

			$arrayResult = array_merge($arrayResult, getSelectTakeBase($model) );
			
			
			
			return $arrayResult;
		}


		function getSelectTakeBaseAllOwn($model, $input){
			if ($input == '0'){
				$value = 'teacher all';
			}else{
				$value = getSelectTakeBaseOwn($model, $input);
			}
			
			return $value;
		}


?>
