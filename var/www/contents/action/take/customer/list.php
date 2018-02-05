<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array('teaching/Base', $arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName']));
		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];

		//共通処理
		$this->getCommon();

		//リストの設定
		$this->$modelName->addModelTool('List');
		$this->$modelName->isSort = $arraySetting['base']['isSort'];
		$this->$modelName->isSearch = $arraySetting['base']['isSearch'];

		$this->$modelName->target = '*,member_base.*,take_base.loginID as takeLoginID,take_base.pass as takePass';
		$this->$modelName->joinTakeBase();
		$this->$modelName->joinCourceBase();
		$this->$modelName->joinCourceStyle();
		
		$tid = getVar($this->arrayAll, 'tid');

		if (isset($this->arrayAll['member_base_id'])){
			$this->$modelName->addQuery('take_base_id', $this->arrayUser['id']);
			$this->set('member_base_id', 1);
		}
		
		$this->set('arraySchedule', $this->$modelName->getFunctionData('Schedule'));

		//特殊検索条件
		$keyword = getVar($this->arrayAll, 'keyword');
		$keyword2 = getVar($this->arrayAll, 'keyword2');

		if ($keyword){
			$this->$modelName->addQuery('(0');		
			$this->$modelName->addQuery('OR memberNameFirst LIKE', '%' . $keyword . '%');
			$this->$modelName->addQuery('OR memberNameSecound LIKE', '%' . $keyword . '%');
			$this->$modelName->addQuery('OR memberNameFirstEnglish LIKE', '%' . $keyword . '%');
			$this->$modelName->addQuery('OR memberNameSecoundEnglish LIKE', '%' . $keyword . '%');
			$this->$modelName->addQuery('OR member_base.id', $keyword);

			$this->$modelName->addQuery('1)');
		}

		if ($keyword2){
			$this->$modelName->addQuery('(0');		
			$this->$modelName->addQuery('OR take_base.nickname LIKE', '%' . $keyword2 . '%');
			$this->$modelName->addQuery('OR take_base.takeNameFirst LIKE', '%' . $keyword2 . '%');
			$this->$modelName->addQuery('OR take_base.takeNameFirst LIKE', '%' . $keyword2 . '%');
			$this->$modelName->addQuery('OR take_base.id', $keyword2);
			$this->$modelName->addQuery('1)');		
		}

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



		list($arrayData, $dbGet) = $this->$modelName->listGetData(getVar($this->arrayAll, 'sortKey'), $arraySearch, getVar($this->arrayAll, 'searchType'));		

		//教材の情報取得
		$arrayType = $this->TeachingBase->getFunctionData('Teaching');
		
		//トライアルの担当講師の取得
		while ($item = $dbGet->getData()){
			$arrayData['arrayList'][$item['id']] = $item;
			
			//TextBook取得
			$arrayData['arrayList'][$item['id']]['arrayText'] = array();
			foreach ($arrayType as $key => $value){
				$id = $item[strtolower($value['value'])];
				
				if ($id){
					$arrayData['arrayList'][$item['id']]['arrayText'][strtolower($value['value'])] = $this->TeachingBase->getDataUID($id)->getData();
				}
			}					
		}		

		//テンプレートで使う変数の設定
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
		$this->set('keyword', $keyword);
		$this->set('tid', $tid);
		$this->set('keyword2', $keyword2);

?>