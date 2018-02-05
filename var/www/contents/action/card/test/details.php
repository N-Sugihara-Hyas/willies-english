<?php
/*
*	オリジナルカード画面
*/
		//モデル情報の読み込み
		$this->addModel(array('test/Base', 'test/Details', 'test/History', 'media/Image'));

		$this->getCommon();

		if (!empty($this->arrayAll['ng'])){
			//間違った問題だけ
			$arrayNG = explode(',', $this->arrayAll['ng']);
			
			$ngPage = 0;			
			foreach ($arrayNG as $key => $item){
				if ($item){
					if ($item == getVar($this->arrayAll, 'did')){
						$ngPage = $key;
					}
				}
			}
			
			$arrayDetails = $this->TestDetails->getDataUID($arrayNG[$ngPage])->getData();

			$tid = $arrayDetails['test_base_id'];
		}elseif (!empty($this->arrayAll['did'])){
			$arrayDetails = $this->TestDetails->getDataUID($this->arrayAll['did'])->getData();

			$tid = $arrayDetails['test_base_id'];
		}else{
			$tid = getVar($this->arrayAll, 'tid');
			$arrayTestHistory = $this->TestHistory->getMyBase($this->arrayUser['id'], $tid)->getData();
		
			$arrayDetails = $this->TestDetails->getBasePage($tid, intval($arrayTestHistory['test_details_id']))->getData();
		}
		
		//ページデータ	
		$this->set('page', $this->TestDetails->getBase($this->arrayUser['id'], $tid)->getCount());
		
		$this->TestDetails->addQuery('test_details.id <=', $arrayDetails['id']);
		$this->set('pageNow', $this->TestDetails->getBase($this->arrayUser['id'], $tid)->getCount());
			
		if (!empty($this->arrayAll['ng'])){
			//間違った問題だけ
			$arrayNext['id'] = $arrayNG[$ngPage+1];
			$arrayBack['id'] = $arrayNG[$ngPage-1];

			$this->set('pageNext', $arrayNext);
			$this->set('pageBack', $arrayBack);
			$this->set('ng', $this->arrayAll['ng']);
			
		}else{	
	
			$arrayBack = $this->TestDetails->getBaseBack($tid, $arrayDetails['id'])->getData();
			$arrayNext = $this->TestDetails->getBaseNext($tid, $arrayDetails['id'])->getData();
		}
			
		if ($arrayDetails['img1']){
			$this->MediaImage->addQuery('fileName', $arrayDetails['img1']);
			$arrayFile = $this->MediaImage->getData()->getData();
		
			if (($arrayFile['mime'] == 'image/jpeg') || ($arrayFile['mime'] == 'image/png') || ($arrayFile['mime'] == 'image/gif')){
				$this->set('isImage', true);
			}
		}
		$this->set('arrayDetails', $arrayDetails);
		$this->set('arrayBack', $arrayBack);
		$this->set('arrayNext', $arrayNext);

		$this->set('arrayTest', $this->TestBase->getDataUID($tid)->getData());
		$this->set('tid', $tid);
		$this->set('countSelect', $this->TestDetails->countSelect);
?>