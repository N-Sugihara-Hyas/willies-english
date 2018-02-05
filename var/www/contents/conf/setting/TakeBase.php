<?php

		/*
		 * コースの取得
		 */
		function getSelectTakeBase($model){
			$modelTarget = $model->getModel('take/Base');

			$modelTarget->target = 'id, nickname as value';
			$arrayResult = $modelTarget->getData()->getDataAll();
			
			if (isset($model->isTakeNon)){
				$arrayResult[0]['id'] = 0;
				$arrayResult[0]['value'] = '-';
			}

			return $arrayResult;
		}


		function getSelectTakeBaseOwn($model, $input){
			$modelTarget = $model->getModel('take/Base');

			$modelTarget->target = 'id, nickname as value';
			$arrayResult = $modelTarget->getDataUID($input)->getData();

			return $arrayResult['value'];
		}


?>
