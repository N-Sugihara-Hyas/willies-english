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
		$this->$modelName->addQuery('(0');
		$this->$modelName->addQuery('OR member_base.state', 1);
		$this->$modelName->addQuery('OR member_base.state', 2);
		$this->$modelName->addQuery('OR member_base.state', 3);
		$this->$modelName->addQuery('1)');

		$this->set('arraySchedule', $this->$modelName->getFunctionData('Schedule'));
		$this->$modelName->joinTakeReserve();

		//特殊検索条件
		$created = getVar($this->arrayAll, 'created');
		$created2 = getVar($this->arrayAll, 'created2');

		$this->$modelName->addQuery('(1');
		//登録日の検索
		/*$this->$modelName->addQuery('(1');
		if ($created){
			$this->$modelName->addQuery('member_base.created >=', $created . ' 00:00:00');
		}

		if ($created2){
			$this->$modelName->addQuery('member_base.created <=', $created2 . ' 23:59:59');
		}
		$this->$modelName->addQuery('1)');

		$this->$modelName->addQuery('OR (1');*/

		//予約の検索
		if ($created){
			$this->$modelName->addQuery('(1');
			$this->$modelName->addQuery('take_reserve.date >=', $created . ' 00:00:00');
			$this->$modelName->addQuery('take_reserve.isTrial', 1);
			$this->$modelName->addQuery('1)');
		}

		if ($created2){
			$this->$modelName->addQuery('(1');
			$this->$modelName->addQuery('take_reserve.date <=', $created2 . ' 23:59:59');
			$this->$modelName->addQuery('take_reserve.isTrial', 1);
			$this->$modelName->addQuery('1)');
		}
		$this->$modelName->addQuery('1)');
		//$this->$modelName->addQuery('1)');

		$this->$modelName->setColum('member/BaseAdmin');

		//リストの取得
		$arraySearch = array();

		$this->$modelName->joinCourceStyle();
		$this->$modelName->limit = $arraySetting['base']['page'];
		$this->$modelName->page = getVar($this->arrayAll, 'page');

		list($arrayData, $dbGet) = $this->$modelName->listGetData(getVar($this->arrayAll, 'sortKey'), $arraySearch, getVar($this->arrayAll, 'searchType'));

		$arrayData['arrayList'] = array();

		while ($item = $dbGet->getData()){
			$arrayData['arrayList'][$item['id']] = $item;

			$this->TakeReserve->joinTakeBase();
			$this->TakeReserve->target = 'take_base.*,take_reserve.*';
			$this->TakeReserve->order = 'take_reserve.date DESC';
			$this->TakeReserve->addQuery('isTrial', 1);
			$this->TakeReserve->addQuery('member_base_id', $item['id']);

			$arrayData['arrayList'][$item['id']]['arrayTrial'] = $this->TakeReserve->getData()->getDataAll();

			if (count($arrayData['arrayList'][$item['id']]['arrayTrial'] ) == 1){
/*				$arrayData['arrayList'][$item['id']]['arrayTrial'][1] = $arrayData['arrayList'][$item['id']]['arrayTrial'][0];
				unset($arrayData['arrayList'][$item['id']]['arrayTrial'][0]);*/
			}

			//第一回レギュラーレッスン情報の取得
			$this->TakeReserve->joinTakeBase();
			$this->TakeReserve->order = 'date ASC';
			$this->TakeReserve->addQuery('isTrial', 0);
			$this->TakeReserve->addQuery('member_base_id', $item['id']);
			$arrayData['arrayList'][$item['id']]['arrayReguler'] = $this->TakeReserve->getData()->getData();
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
		$this->set('arrayStateDaily', $this->$modelName->getFunctionData('MemberStateDaily'));

		$this->set('arraySettingAdmin', $arraySetting['base']);
		$this->set('created', $created);
		$this->set('created2', $created2);
		$this->set('SecurtyCode', new SecurtyCode($this->arraySetting['secretKey']));

		//Feedbackはcyndyの情報でログインするようにさせる
		$arrayTake = $this->TakeBase->getDataUID(1)->getData();
		
		$this->set('arrayTake', $arrayTake);
?>