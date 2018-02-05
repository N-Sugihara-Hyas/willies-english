<?php

		/*
		 * コースの取得
		 */
		function getSelectTeachingLesson($model){
			
			
			$modelTarget = $model->getModel('teaching/Lesson');

			$modelTarget->target = 'id, lessonName as value';


			$arrayResult = $modelTarget->getData()->getDataAll();
			
			return $arrayResult;
		}


		function getSelectTeachingLessonOwn($model, $input){
			$model = $model->getModel('teaching/Lesson');

			$model->target = 'id, lessonName as value';

			$arrayResult = $model->getDataUID($input)->getData();

			return $arrayResult['value'];
		}


?>
