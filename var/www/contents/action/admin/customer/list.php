<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName'], 'take/Reserve', 'take/Base'));
		$this->addLiblary(array('securty/Code'));
		
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
		$this->set('arraySchedule', $this->$modelName->getFunctionData('Schedule'));

		//特殊検索条件
		$keyword = getVar($this->arrayAll, 'keyword');
		$tid = getVar($this->arrayAll, 'tid');

		if ($keyword){
			$this->$modelName->addQuery('(0');
			$this->$modelName->addQuery('OR memberNameFirst LIKE', '%' . $keyword . '%');
			$this->$modelName->addQuery('OR memberNameSecound LIKE', '%' . $keyword . '%');
			$this->$modelName->addQuery('OR memberNameFirstEnglish LIKE', '%' . $keyword . '%');
			$this->$modelName->addQuery('OR memberNameSecoundEnglish LIKE', '%' . $keyword . '%');
			$this->$modelName->addQuery('OR member_base.id', $keyword);

			$this->$modelName->addQuery('1)');
		}

		$this->$modelName->setSession('returnURL', str_replace('/admin/', '', $_SERVER['REQUEST_URI']));

		$createdStart = getVar($this->arrayAll, 'createdStart');
		$createdEnd = getVar($this->arrayAll, 'createdEnd');

		$this->set('createdStart', $createdStart);
		$this->set('createdEnd', $createdEnd);

		if ($createdStart){$this->$modelName->addQuery('datePay >=', $createdStart);}
		if ($createdEnd){$this->$modelName->addQuery('datePay <=', $createdEnd);}


		//講師の選択
		$this->set('arrayTakeBase', $this->TakeBase->getData()->getDataAll());

		if ($tid){
			$this->$modelName->addQuery('take_base.id', $tid);
		}

		$this->$modelName->setColum('member/BaseAdmin');

		//リストの取得
		$arraySearch = array();
		if (isset($this->arrayAll['arrayInput'][$modelName])){
			$arraySearch = $this->arrayAll['arrayInput'][$modelName];
		}

		$this->$modelName->limit = $arraySetting['base']['page'];
		$this->$modelName->page = getVar($this->arrayAll, 'page');


		if (isset($this->arrayAll['isPayOut'])){
			$isPayOut = $this->arrayAll['isPayOut'];
			$this->$modelName->addQuery('isPayAuto', 0);
			$this->set('isPayOut', 1);
		}else{
			$this->set('isPayOut', 0);
		}

		if (!empty($this->arrayAll['orderID1'])){
			$this->$modelName->addQuery('orderID1', $this->arrayAll['orderID1']);
		}
		
		
		list($arrayData, $dbGet) = $this->$modelName->listGetData(getVar($this->arrayAll, 'sortKey'), $arraySearch, getVar($this->arrayAll, 'searchType'));
		
		$arrayData['arrayList'] = array();
		
		//トライアルの担当講師の取得
		while ($item = $dbGet->getData()){
			$this->TakeReserve->joinTakeBase();
			$this->TakeReserve->addQuery('isTrial', 1);
			$this->TakeReserve->addQuery('member_base_id', $item['id']);
			$arrayTrial = $this->TakeReserve->getData()->getData();
			
			$arrayData['arrayList'][$item['id']] = $item;
			$arrayData['arrayList'][$item['id']]['arrayTrial'] = $arrayTrial;
		}
		

		$this->$modelName->unSelect ='未選択';

		//テンプレートで使う変数の設定
		$this->set('searchType', $this->$modelName->searchType);
		$this->set('my', '/' . $this->arrayAction['dir'] . $this->arrayAction['a'] . '/');
		$this->set('arrayColum', $this->$modelName->arrayColum);
		$this->set('e', getVar($this->arrayAll, 'e'));
		$this->set('page', $this->$modelName->page);
		$this->set('modelName', $modelName);
		$this->set('arrayData', $arrayData);
		$this->set('arrayInput', $this->$modelName->arrayInput);

		$this->set('arraySettingAdmin', $arraySetting['base']);
		$this->set('keyword', $keyword);
		$this->set('tid', $tid);
		$this->set('SecurtyCode', new SecurtyCode($this->arraySetting['secretKey']));


		
		$this->set('arrayState', $this->TakeBase->getFunctionData('MemberState'));
		$this->set('arrayStateDaily', $this->TakeBase->getFunctionData('MemberStateDaily'));

?>