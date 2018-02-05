<?php

		/*
		 * どこでしったかの取得
		 */
		function getSelectLevel($model){
			for ($i = 1; $i <= $model->arraySetting['level']; $i++){
				$arryaLevel[$i]['id'] = $i;
				$arryaLevel[$i]['value'] = $i;
			}
			
			return $arryaLevel;
		}


?>
