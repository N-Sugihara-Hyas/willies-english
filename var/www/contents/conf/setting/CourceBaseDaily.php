<?php

		/*
		 * コースの取得
		 */
		function getSelectCourceBaseDaily($model){
			
			
			$model = $model->getModel('cource/BaseDaily');

			if (strpos($model->arrayAction['dir'], 'take/') !== FALSE){
				$model->target = 'id, courceNameEnglish as value,level';
			}else{
				$model->target = 'id, courceName as value';
			}
			
			$arrayResult = $model->getData()->getDataAll();
			
			return $arrayResult;
		}


		function getSelectCourceBaseDailyOwn($model, $input){
			$model = $model->getModel('cource/BaseDaily');

			if (strpos($model->arrayAction['dir'], 'take/') !== FALSE){
				$model->target = 'id, courceNameEnglish as value';
			}else{
				$model->target = 'id, courceName as value';
			}

			$arrayResult = $model->getDataUID($input)->getData();

			return $arrayResult['value'];
		}


?>
