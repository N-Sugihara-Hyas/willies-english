<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array('take/Schedule', $arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName']));
		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];

		//共通処理
		$this->getCommon();

		//リストの設定
		$this->$modelName->addModelTool('List');
		$this->$modelName->isSort = $arraySetting['base']['isSort'];
		$this->$modelName->isSearch = $arraySetting['base']['isSearch'];

		$this->$modelName->setColum();

		//リストの取得
		$arraySearch = array();
		if (isset($this->arrayAll['arrayInput'][$modelName])){
			$arraySearch = $this->arrayAll['arrayInput'][$modelName];
		}

		$this->$modelName->limit = $arraySetting['base']['page'];
		$this->$modelName->page = getVar($this->arrayAll, 'page');


		$this->$modelName->joinTakeSchedule();


		if (getVar($this->arrayAll, 'week')){
			$this->$modelName->addQuery('week', getVar($this->arrayAll, 'week'));
		}
		
		if (getVar($this->arrayAll, 'time')){
			$this->$modelName->addQuery('time', getVar($this->arrayAll, 'time'));
		}
		
		$this->set('arrayTime', $this->TakeSchedule->getArrayTime());
		
		$this->set('week', getVar($this->arrayAll, 'week'));
		$this->set('time', getVar($this->arrayAll, 'time'));
				
		list($arrayData, $arrayList) = $this->$modelName->listGetData(getVar($this->arrayAll, 'sortKey'), $arraySearch, getVar($this->arrayAll, 'searchType'));
		$arrayData['arrayList'] = $arrayList;

		//テンプレートで使う変数の設定
		$this->set('searchType', $this->$modelName->searchType);
		$this->set('arrayColum', $this->$modelName->arrayColum);
		$this->set('e', getVar($this->arrayAll, 'e'));
		$this->set('page', $this->$modelName->page);
		$this->set('modelName', $modelName);
		$this->set('arrayData', $arrayData);
		$this->set('arrayInput', $this->$modelName->arrayInput);

		$this->set('arraySettingAdmin', $arraySetting['base']);

?>