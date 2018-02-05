<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName'], 'member/Base', 'take/Base'));
		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];
		$this->addLiblary(array('securty/Code'));
		
		//共通処理
		$this->getCommon();

		//リストの設定
		$this->$modelName->addModelTool('List');
		$this->$modelName->isSort = $arraySetting['base']['isSort'];
		$this->$modelName->isSearch = $arraySetting['base']['isSearch'];

		
		$this->$modelName->setColum();


		if (isset($this->arrayAll['type'])){
			$mID = $this->arrayAll['type'];
			$this->$modelName->setSession('type', $this->arrayAll['type']);
		}

		$type = $this->$modelName->getSession('type');

		$this->$modelName->addQuery('type', $type);

		//リストの取得
		$arraySearch = array();
		if (isset($this->arrayAll['arrayInput'][$modelName])){
			$arraySearch = $this->arrayAll['arrayInput'][$modelName];
		}

		$this->$modelName->limit = $arraySetting['base']['page'];
		$this->$modelName->page = getVar($this->arrayAll, 'page');
		$this->$modelName->target = '*,card_base.*';

		if ($type == 3){
			$this->$modelName->joinAdminLogin();
		}
		if ($type == 2){
			$this->$modelName->target.= ',member_base.*,card_base.id as id';
			$this->$modelName->joinMemberBase();
		
		}
		if ($type == 1){
			$this->$modelName->joinTakeBase();
			$this->$modelName->joinMemberBase();
		}

		//$this->$modelName->addCardDetails();
		$this->$modelName->addCardMember();

		list($arrayData, $arrayList) = $this->$modelName->listGetData(getVar($this->arrayAll, 'sortKey'), $arraySearch, getVar($this->arrayAll, 'searchType'));
		$arrayData['arrayList'] = $arrayList;

		$this->set('TakeBase', $this->TakeBase);
		$this->set('type', $type);
		$this->set('searchType', $this->$modelName->searchType);
		$this->set('my', '/' . $this->arrayAction['dir'] . $this->arrayAction['a'] . '/');
		$this->set('arrayColum', $this->$modelName->arrayColum);
		$this->set('e', getVar($this->arrayAll, 'e'));
		$this->set('page', $this->$modelName->page);
		$this->set('modelName', $modelName);
		$this->set('arrayData', $arrayData);
		$this->set('arrayInput', $this->$modelName->arrayInput);
		$this->set('SecurtyCode', new SecurtyCode($this->arraySetting['secretKey']));
		
		$this->set('arraySettingAdmin', $arraySetting['base']);

?>