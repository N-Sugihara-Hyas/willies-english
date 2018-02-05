<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName'], 'take/Base', 'take/Reserve'));
		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];
		$this->addLiblary(array('securty/Code'));
		
		//共通処理
		$this->getCommon();

		//リストの設定
		$this->$modelName->addModelTool('List');
		$this->$modelName->isSort = $arraySetting['base']['isSort'];
		$this->$modelName->isSearch = $arraySetting['base']['isSearch'];


		
		$tid = getVar($this->arrayAll, 'tid');

		if (isset($this->arrayAll['member_base_id'])){
			$this->$modelName->addQuery('take_base_id', $this->arrayUser['id']);
			$this->set('member_base_id', 1);
		}
		
		$this->set('arraySchedule', $this->$modelName->getFunctionData('Schedule'));



		$this->$modelName->setColum('member/BaseAdmin');

		if ($tid){
			$this->$modelName->addQuery('take_base.id', $tid);
		}

		//講師の選択
		$this->set('arrayTakeBase', $this->TakeBase->getData()->getDataAll());

		//リストの取得
		$arraySearch = array();
		if (isset($this->arrayAll['arrayInput'][$modelName])){
			$arraySearch = $this->arrayAll['arrayInput'][$modelName];
		}
			

		$this->$modelName->limit = $arraySetting['base']['page'];
		$this->$modelName->page = getVar($this->arrayAll, 'page');

		$this->$modelName->target = '*,member_base.*,member_base.id,take_base.nickname as nickname';
		$this->$modelName->joinMemberBase();
		$this->$modelName->joinTakeBase();
		$this->$modelName->joinCourceBase();
		$this->$modelName->joinCourceStyle();
		$this->$modelName->addQuery('company_base_id', $this->arrayUser['id']);
		list($arrayData, $arrayList) = $this->$modelName->listGetData(getVar($this->arrayAll, 'sortKey'), $arraySearch, getVar($this->arrayAll, 'searchType'));
		$arrayData['arrayList'] = $arrayList;

		$arrayList = array();
		while ($objData = $arrayData['arrayList']->getData()){		
			//第一回レギュラーレッスン情報の取得
			$this->TakeReserve->joinTakeBase();
			$this->TakeReserve->order = 'date ASC';
			//$this->TakeReserve->addQuery('isTrial', 0);
			$this->TakeReserve->addQuery('member_base_id', $objData['id']);
			$objData['arrayReguler'] = $this->TakeReserve->getData()->getData();
						
			array_push($arrayList, $objData);
		}
		
		$this->set('arrayWeek', $this->$modelName->getFunctionData('Schedule'));
		//テンプレートで使う変数の設定
		$this->set('arrayList', $arrayList);
		$this->set('searchType', $this->$modelName->searchType);
		$this->set('my', '/' . $this->arrayAction['dir'] . $this->arrayAction['a'] . '/');
		$this->set('arrayColum', $this->$modelName->arrayColum);
		$this->set('e', getVar($this->arrayAll, 'e'));
		$this->set('page', $this->$modelName->page);
		$this->set('modelName', $modelName);
		$this->set('arrayData', $arrayData);
		$this->set('arrayInput', $this->$modelName->arrayInput);
		$this->set('arrayState', $this->$modelName->getFunctionData('MemberState'));

		
		$this->set('arraySettingAdmin', $arraySetting['base']);

?>