<?php
/*
*	オリジナルカード画面
*/
		//モデル情報の読み込み
		$this->addModel(array('test/Base', 'test/Details', 'test/History'));

		$this->getCommon();


		$arrayAnser = $this->TestDetails->getAnser();
		if ($arrayAnser){
			$mode = 'save';
		}else{
			$arrayAnser = $this->TestDetails->getAnserStatic();
			$mode = 'load';
		}

		$count = 0;
		$hit = 0;
		$ng = '';
		foreach ($arrayAnser as $key => $item){
			$arrayDetails = $this->TestDetails->getDataUID($key)->getData();
				
			$arrayData[$count] = $item;
			$arrayData[$count]['arrayDetails'] = $arrayDetails;
			$arrayData[$count]['hit'] = $arrayDetails['hit'];
			$arrayData[$count]['select'] = $item['select'];
			
			$this->TestDetails->addQuery('test_details.id <=', $arrayDetails['id']);
			$arrayData[$count]['pageNow'] = $this->TestDetails->getBase($this->arrayUser['id'], $tid)->getCount();

			
			if ($item['isOK']){
				$hit++;
			}else{
				$ng.=$arrayData[$count]['arrayDetails']['id'] . ',';
			}

			$count++;
		}

		$point = intval(($hit / $count) * 100);

		$this->set('count', $count);
		$this->set('arrayData', $arrayData);
		$this->set('arrayTest', $this->TestBase->getDataUID($arrayDetails['test_base_id'])->getData());

		$this->set('point', $point);

		//履歴の更新
		if ($mode == 'save'){
			$this->TestHistory->addQuery('member_base_id', $this->arrayUser['id']);
			$this->TestHistory->addQuery('test_base_id', $arrayDetails['test_base_id']);
			$arrayData = $this->TestHistory->getData()->getData();

			$arrayData['member_base_id'] = $this->arrayUser['id'];
			$arrayData['test_base_id'] = $arrayDetails['test_base_id'];
			$arrayData['test_details_id'] = $did;
			$arrayData['anser'] = '';
			$arrayData['point'] = $point;
			$arrayData['count'] = intval($arrayData['count']) + 1;
			$arrayData['ng'] = $ng;

			$this->TestHistory->commit($arrayData);
		}

		//ページデータ
		$this->set('page', $this->TestDetails->getBase($this->arrayUser['id'], $tid)->getCount());
		$this->set('ng', $ng);
		//回答を削除し、一時保存型に
		$this->TestDetails->changeAnser($arrayAnser);
?>