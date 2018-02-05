<?php
/*
*	ログイン画面
*/

		//モデル情報の読み込み
		$this->addModel(array('member/Base', 'take/Reserve', 'ext/Homework', 'card/Base'));
		$this->getCommon();

		//商品の取得
		$page = getVar($this->arrayAll, 'page');
		$this->TakeReserve->addModelTool('Page');
		
		$this->TakeReserve->joinTakeBase();
		$this->TakeReserve->order = 'date DESC';
		$this->TakeReserve->group = '*';
		$this->TakeReserve->addQuery('date <=', date('Y-m-d H:i:s'));
		$this->TakeReserve->addQuery('take_reserve.member_base_id', $this->uid);
		$dbGet = $this->TakeReserve->getData();
		
		$arrayData = $this->TakeReserve->pageGetData($dbGet, $page, 20);
		
		$arrayList = array();
		while ($item = $arrayData['dbGet']->getData()){
			$item['objHomework'] = $this->ExtHomework->getTarget($item)->getData();
			$item['objCard'] = $this->CardBase->getTarget($item)->getData();
			
			array_push($arrayList, $item);
		}
				
		$this->set('objMember2', $this->MemberBase->getDataUID($this->uid)->getData());
		$this->set('arrayData', $arrayData);
		$this->set('arrayList', $arrayList);
		$this->set('page', $page);
		$this->set('uid', $this->uid);
		$this->set('my', substr($_SERVER['REQUEST_URI'], 1));


?>