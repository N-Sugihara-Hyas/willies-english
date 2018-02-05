<?php
/*
*	オリジナルカード画面
*/
		//モデル情報の読み込み
		$this->addModel(array('card/Base', 'card/Details'));

		$this->getCommon();

		$this->CardBase->target = '*,card_base.*';
		$dbGet = $this->CardBase->getMy($this->arrayUser['id'], 2);
		$this->CardBase->addModelTool('Page');
		
		$page = getVar($this->arrayAll, 'page');
		$arrayData = $this->CardBase->pageGetData($dbGet, $page, 20);

		$this->CardDetails->setSession('uid', '');

		$this->set('arrayAction', $this->arrayAction);
		$this->set('page', $page);
		$this->set('arrayData', $arrayData);

?>