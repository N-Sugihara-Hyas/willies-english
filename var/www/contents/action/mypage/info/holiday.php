<?php
/*
*	ログイン画面
*/

		//モデル情報の読み込み
		$this->addModel(array('ext/Holiday'));
		$this->getCommon();

		//商品の取得
		$page = getVar($this->arrayAll, 'page');
		$this->ExtHoliday->addModelTool('Page');

		$this->ExtHoliday->order = 'dateStart ASC';
		$this->ExtHoliday->addQuery('dateStart >=', date('Y-m-d'));
		$dbGet = $this->ExtHoliday->getData();
		$arrayData = $this->ExtHoliday->pageGetData($dbGet, $page, 20);

		$this->set('arrayData', $arrayData);
		$this->set('page', $page);
		$this->set('my', substr($_SERVER['REQUEST_URI'], 1));


?>