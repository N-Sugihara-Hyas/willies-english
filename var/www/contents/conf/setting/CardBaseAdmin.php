<?php

		/*
		 * コースの取得
		 */
		function getSelectCardBaseAdmin($modelBase){
			$model = $modelBase->getModel('card/Base');
			$model->order = 'id ASC';

			$model->target = 'id, cardName as value';
			$model->addQuery('type', 3);
			$arrayResult = $model->getData()->getDataAll();
			
			return $arrayResult;
		}


		function getSelectCardBaseAdminOwn($model, $input){
			$model = $model->getModel('card/Base');

			$model->target = 'id, cardName as value';

			$arrayResult = $model->getDataUID($input)->getData();

			return $arrayResult['value'];
		}


?>
