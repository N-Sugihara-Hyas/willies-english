<?php

		/*
		 * コースの取得
		 */
		function getSelectCourceBaseAll($model){
			
			
			$model = $model->getModel('cource/Base');

			$model->target = 'id, courceNameEnglish as value';
			$arrayResult = $model->getData()->getDataAll();
			
			$arrayResult = array_merge(array('0' => array('id' => '0', 'value' => 'ALL')), $arrayResult);
			return $arrayResult;
		}


		function getSelectCourceBaseAllOwn($model, $input){
			$model = $model->getModel('cource/Base');

			if (strpos($model->arrayAction['dir'], 'take/') !== FALSE){
				$model->target = 'id, courceNameEnglish as value';
			}else{
				$model->target = 'id, courceName as value';
			}

			$arrayResult = $model->getDataUID($input)->getData();

			return $arrayResult['value'];
		}


?>
