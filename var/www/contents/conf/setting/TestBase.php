<?php

		/*
		 * コースの取得
		 */
		function getSelectTestBase($modelBase){
			$model = $modelBase->getModel('test/Base');
			$model->order = 'id ASC';

			$model->target = 'id, testName as value';
			$arrayResult = $model->getData()->getDataAll();
			
			$arrayPush[''] = array('id' => '', 'value' => '未選択');
			$arrayPush = array_merge($arrayPush, $arrayResult);

			return $arrayPush;
		}


		function getSelectTestBaseOwn($model, $input){
			$model = $model->getModel('test/Base');

			$model->target = 'id, testName as value';

			$arrayResult = $model->getDataUID($input)->getData();

			return $arrayResult['value'];
		}


?>
