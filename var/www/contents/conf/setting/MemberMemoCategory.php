<?php

		/*
		 * コースの取得
		 */
		function getSelectMemberMemoCategory($model){
			$modelTarget = $model->getModel('member/MemoCategory');

			
			$modelTarget->target = 'id, categoryName as value';
			
			if (isset($model->arrayUser)){
				$modelTarget->addQuery('member_base_id', $model->arrayUser['id']);
			}
			$arrayResult = $modelTarget->getData()->getDataAll();
			
			return $arrayResult;
		}


		function getSelectMemberMemoCategoryOwn($model, $input){
			$modelTarget = $model->getModel('member/MemoCategory');

			$modelTarget->target = 'id,categoryName as value';
			$arrayResult = $modelTarget->getDataUID($input)->getData();

			return $arrayResult['value'];
		}


?>
