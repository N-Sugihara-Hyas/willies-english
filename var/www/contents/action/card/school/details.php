<?php
/*
*	オリジナルカード画面
*/
		//モデル情報の読み込み
		$this->addModel(array('card/Base', 'card/Details', 'master/NewsCard'));

		$this->getCommon();

		$arrayCardBase = $this->CardBase->getMy($this->arrayUser['id'], 3, $this->uid)->getData();

		if (!$arrayCardBase){
			$this->setRedirect('errors');
		}

		$this->CardDetails->addModelTool('Page');

		$this->CardDetails->target = '*,card_details.*';

		if (getVar($this->arrayAll, 'mode') == 'star'){
			$dbGet = $this->CardDetails->getMyStar(1, $this->arrayUser['id'], $this->uid, 3);
		}elseif (getVar($this->arrayAll, 'mode') == 'nonStar'){
			$dbGet = $this->CardDetails->getMyStar(0, $this->arrayUser['id'], $this->uid, 3);
		}else{
			$dbGet = $this->CardDetails->getMyBase($this->arrayUser['id'], $this->uid, 3);
		}

		
		$page = getVar($this->arrayAll, 'page');
		$arrayData = $this->CardDetails->pageGetData($dbGet, $page, 20);

		$this->MasterNewsCard->setOpen($this->arrayUser['id'], $this->uid);

		$this->set('page', $page);
		$this->set('arrayData', $arrayData);
		$this->set('arrayCardBase', $arrayCardBase);


?>