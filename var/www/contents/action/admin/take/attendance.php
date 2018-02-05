<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf2.php';
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

		//授業が終わってるのに終了してないものは終了扱いにする
		//$this->$modelName->addQuery('CONCAT(date, " ",timeStart) <=', date('Y-m-d H:i:s'));
		//$this->$modelName->setData(array('isOK' => -1));

		$takeName = getVar($this->arrayAll, 'takeName');
		$this->set('takeName', $takeName);
		$dateStart = getVar($this->arrayAll, 'dateStart');
		$this->set('dateStart', $dateStart);
		$dateEnd = getVar($this->arrayAll, 'dateEnd');
		$this->set('dateEnd', $dateEnd);

		$this->$modelName->limit = $arraySetting['base']['page'];
		$this->$modelName->page = getVar($this->arrayAll, 'page');


		$this->$modelName->joinTakeBase();


		$isDate = true;

		$this->$modelName->addQuery('(0');
		$this->$modelName->addQuery('OR isOK', -1);
		$this->$modelName->addQuery('OR isOK', -2);
		$this->$modelName->addQuery('OR 0)');

		if ($takeName){
			$this->$modelName->addQuery('takeName LIKE', '%' . $takeName . '%');
		}
		if ($dateStart){
			$this->$modelName->addQuery('dateTime >=',  $dateStart);
			$isDate = false;
		}
		if ($dateEnd){
			$this->$modelName->addQuery('dateTime <=',  $dateEnd);
			$isDate = false;
		}

		$this->$modelName->order = 'dateTime DESC';
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