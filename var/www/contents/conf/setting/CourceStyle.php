<?php

		/*
		 * コースの取得
		 */
		function getSelectCourceStyle($model){
			$model = $model->getModel('cource/Style');

			$model->target = 'id, courceStyleName as value';
			$arrayResult = $model->getData()->getDataAll();
			
			return $arrayResult;
		}

		function getSelectCourceStyleOwn($model, $input){
			$model = $model->getModel('cource/Style');

			$model->target = 'id, courceStyleName as value';
			$arrayResult = $model->getDataUID($input)->getData();

			return $arrayResult['value'];
		}

?>
