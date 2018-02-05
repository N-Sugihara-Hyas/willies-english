<?php
/*
*	ログイン画面
*/

		//モデル情報の読み込み
		$this->addModel(array('take/Reserve'));
		$this->getCommon();

		//商品の取得
		$page = getVar($this->arrayAll, 'page');
		$this->TakeReserve->addModelTool('Page');


		$this->TakeReserve->joinTakeBase();
		$this->TakeReserve->order = 'date DESC';
		$this->TakeReserve->addQuery('date <=', date('Y-m-d H:i:s'));
		$this->TakeReserve->addQuery('take_reserve.member_base_id', $this->arrayUser['id']);
		$dbGet = $this->TakeReserve->getData();
		$arrayData = $this->TakeReserve->pageGetData($dbGet, $page, 20);

		$this->set('arrayData', $arrayData);
		$this->set('page', $page);
		$this->set('my', substr($_SERVER['REQUEST_URI'], 1));


?>