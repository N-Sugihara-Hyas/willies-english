<?php
/*
*	オリジナルカード画面
*/
		//モデル情報の読み込み
		$this->addModel(array('card/Base', 'card/Details'));

		$this->getCommon();

		$arrayCardBase = $this->CardBase->getMy($this->arrayUser['id'], 2, $this->uid)->getData();

		if (!$arrayCardBase){
			$this->setRedirect('errors');
		}

		$this->CardDetails->addModelTool('Page');

		$this->CardDetails->target = '*,card_details.*';

		if (getVar($this->arrayAll, 'mode') == 'star'){
			$dbGet = $this->CardDetails->getMyStar(1, $this->arrayUser['id'], $this->uid);
		}elseif (getVar($this->arrayAll, 'mode') == 'nonStar'){
			$dbGet = $this->CardDetails->getMyStar(0, $this->arrayUser['id'], $this->uid);
		}else{
			$dbGet = $this->CardDetails->getMyBase($this->arrayUser['id'], $this->uid);
		}

		
		$page = getVar($this->arrayAll, 'page');
		$arrayData = $this->CardDetails->pageGetData($dbGet, $page, 20);

		$this->set('page', $page);
		$this->set('arrayData', $arrayData);
		$this->set('arrayCardBase', $arrayCardBase);


?>