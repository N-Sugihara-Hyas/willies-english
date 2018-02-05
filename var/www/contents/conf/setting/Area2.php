<?php

		/*
		 * 都道府県の取得
		 */
		function getSelectArea2($model){
			$SettingArea2 = $model->getModel('setting/Area2');

			$dbGet = $SettingArea2->getData();
			
			$arrayResult[0]['id'] = '';
			$arrayResult[0]['value'] = '都道府県';
			
			while ($item = $dbGet->getData()){
				$arrayResult[$item['id']]['id'] = $item['id'];
				$arrayResult[$item['id']]['value'] = $item['area2Name'];
			}
			
			return $arrayResult;
		}

?>
