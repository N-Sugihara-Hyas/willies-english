<?php

		/*
		 * コースの取得
		 */
		function getSelectTestType($modelBase){
			$model = $modelBase->getModel('test/Type');
			$model->order = 'id ASC';

			$model->target = 'id, typeName as value';
			$arrayResult = $model->getData()->getDataAll();
			
			return $arrayResult;
		}


		function getSelectTestTypeOwn($model, $input){
			$model = $model->getModel('test/Type');

			$model->target = 'id, typeName as value';

			$arrayResult = $model->getDataUID($input)->getData();

			return $arrayResult['value'];
		}


?>
