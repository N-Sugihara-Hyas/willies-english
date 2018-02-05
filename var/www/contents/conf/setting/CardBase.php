<?php

		/*
		 * コースの取得
		 */
		function getSelectCardBase($modelBase){
			
			
			$model = $modelBase->getModel('card/Base');
			$model->order = 'id ASC';

			$model->target = 'id, cardName as value';

			if ($modelBase->uid){
				$model->addQuery('member_base_id', $modelBase->uid);
			}
			if ($modelBase->type){
				$model->addQuery('type', $modelBase->type);
			}

			$arrayResult = $model->getData()->getDataAll();

			$arrayPush[''] = array('id' => '', 'value' => '未選択');
			$arrayPush = array_merge($arrayPush, $arrayResult);

			return $arrayPush;
		}


		function getSelectCardBaseOwn($model, $input){
			$model = $model->getModel('card/Base');

			$model->target = 'id, cardName as value';

			$arrayResult = $model->getDataUID($input)->getData();

			return $arrayResult['value'];
		}


?>
