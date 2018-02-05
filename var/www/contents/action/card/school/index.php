<?php
/*
*	オリジナルカード画面
*/
		//モデル情報の読み込み
		$this->addModel(array('card/Base'));

		$this->getCommon();
				
		$this->CardBase->joinTakeBase();
		if (getVar($this->arrayAll, 'mode') == 'star'){
			$dbGet = $this->CardBase->getMyStar(1, $this->arrayUser['id'], 3, 0, $this->arrayUser['cource_base_id']);
		}elseif (getVar($this->arrayAll, 'mode') == 'nonStar'){
			$dbGet = $this->CardBase->getMyStar(0, $this->arrayUser['id'], 3, 0, $this->arrayUser['cource_base_id']);
		}else{
			$dbGet = $this->CardBase->getMy($this->arrayUser['id'], 3, 0, $this->arrayUser['cource_base_id']);
		}

		$this->CardBase->addModelTool('Page');
		
		$page = getVar($this->arrayAll, 'page');
		$arrayData = $this->CardBase->pageGetData($dbGet, $page, 20);

		$this->set('type', getVar($this->arrayAll, 'mode'));
		$this->set('page', $page);
		$this->set('arrayData', $arrayData);

?>