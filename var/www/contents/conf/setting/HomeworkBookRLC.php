<?php

		/*
		 * コースの取得
		 */
		function getSelectHomeworkBookRLC($model){
			
			
			$model = $model->getModel('ext/HomeworkBook');

			
			$model->target = 'id, title as value';
			$arrayResult = $model->getDataType(2)->getDataAll();
			
			return $arrayResult;
		}


		function getSelectHomeworkBookRLCOwn($model, $input){
			$model = $model->getModel('ext/HomeworkBook');

			$model->target = 'id,title as value';
			$arrayResult = $model->getDataUID($input)->getData();

			return $arrayResult['value'];

		}


?>
