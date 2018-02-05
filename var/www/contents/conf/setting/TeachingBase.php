<?php

		/*
		 * コースの取得
		 */
		function getSelectTeachingBase($model){
			$modelTarget = $model->getModel('teaching/Base');
			$modelTarget->target = 'id, teachingName as value';

			$modelTarget->addQuery('(0');
			if (!empty($model->isCategory)){
				if (is_array($model->arrayInput['category'])){
					foreach ($model->arrayInput['category'] as $key => $value){
						$modelTarget->addQuery('OR category LIKE', '%"' . $value . '"%');					
					}
				}
			}
			$modelTarget->addQuery('OR 0)');

			
			$arrayResult = $modelTarget->getData()->getDataAll();
			
			return $arrayResult;
		}


		function getSelectTeachingBaseOwn($model, $input){
			$model = $model->getModel('teaching/Base');
			$model->target = 'id, teachingName as value';
			
			$arrayResult = $model->getDataUID($input)->getData();

			return $arrayResult['value'];
		}


?>
