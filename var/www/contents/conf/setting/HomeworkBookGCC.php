<?php

		/*
		 * コースの取得
		 */
		function getSelectHomeworkBookGCC($model){
			
			
			$model = $model->getModel('ext/HomeworkBook');

			
			$model->target = 'id, title as value';
			$arrayResult = $model->getDataType(1)->getDataAll();
			
			return $arrayResult;
		}


		function getSelectHomeworkBookGCCOwn($model, $input){
			$model = $model->getModel('ext/HomeworkBook');

			$model->target = 'id,title as value';
			$arrayResult = $model->getDataUID($input)->getData();

			return $arrayResult['value'];
		}


?>
