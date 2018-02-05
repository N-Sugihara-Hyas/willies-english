<?php
/*
*	ログイン画面
*/

		//モデル情報の読み込み
		$this->addModel(array('take/Base'));
		$this->getCommon();

		//商品の取得
		$page = getVar($this->arrayAll, 'page');
		$this->TakeBase->addModelTool('Page');


		$this->TakeBase->addQuery('fb IS NOT NULL');
		$dbGet = $this->TakeBase->getData();
		$arrayData = $this->TakeBase->pageGetData($dbGet, $page, 20);

		$this->set('arrayData', $arrayData);
		$this->set('page', $page);
		$this->set('my', substr($_SERVER['REQUEST_URI'], 1));


?>