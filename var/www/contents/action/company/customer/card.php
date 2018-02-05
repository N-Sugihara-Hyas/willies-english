<?php
/*
*	オリジナルカード画面
*/
		//モデル情報の読み込み
		$this->addModel(array('company/Member', 'card/Base', 'card/Details', 'master/NewsCard'));
		
		$this->getCommon();

		
		if (!$this->arrayAll['mid']){
			$this->setRedirect('errors');			
		}
		
		$arrayCheck = $this->CompanyMember->getCompanyMember($this->arrayUser['id'], $this->arrayAll['mid'])->getData();
		
		if (!$arrayCheck){
			$this->setRedirect('errors');
		}
		
		$this->CardBase->joinTakeBase();
		$arrayCardBase = $this->CardBase->getMy($this->arrayAll['mid'], 1, $this->uid)->getData();


		$this->CardDetails->addModelTool('Page');

		$this->CardDetails->target = '*,card_details.*';

		if (getVar($this->arrayAll, 'mode') == 'star'){
			$dbGet = $this->CardDetails->getMyStar(1, $this->arrayAll['mid'], $this->uid);
		}elseif (getVar($this->arrayAll, 'mode') == 'nonStar'){
			$dbGet = $this->CardDetails->getMyStar(0, $this->arrayAll['mid'], $this->uid);
		}else{
			$dbGet = $this->CardDetails->getMyBase($this->arrayAll['mid'], $this->uid);
		}
		
		$page = getVar($this->arrayAll, 'page');
		$arrayData = $this->CardDetails->pageGetData($dbGet, $page, 200);
		$this->set('count', $dbGet->getCount());


		$this->set('page', $page);
		$this->set('arrayData', $arrayData);
		$this->set('arrayCardBase', $arrayCardBase);


?>