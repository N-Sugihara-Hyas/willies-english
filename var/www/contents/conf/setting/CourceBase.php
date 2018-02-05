<?php

		/*
		 * コースの取得
		 */
		function getSelectCourceBase($model){
			
			
			$model = $model->getModel('cource/Base');

			if (strpos($model->arrayAction['dir'], 'take/') !== FALSE){
				$model->target = 'id, courceNameEnglish as value';
			}else{
				$model->target = 'id, courceName as value';
			}
			
			$arrayResult = $model->getData()->getDataAll();
			
			return $arrayResult;
		}


		function getSelectCourceBaseOwn($model, $input){
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
