<?php

		/*
		 * 時間の取得
		 */
		function getSelectTime($model){
			$TakeSchedule = $model->getModel('take/Schedule');


			return $TakeSchedule->getArrayTime();
		}

?>
