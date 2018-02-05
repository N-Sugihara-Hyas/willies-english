<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName'], 'member/Base'));
		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];

		//共通処理
		$this->getCommon();

		//リストの設定
		$this->$modelName->addModelTool('List');
		$this->$modelName->isSort = $arraySetting['base']['isSort'];
		$this->$modelName->isSearch = $arraySetting['base']['isSearch'];

		$this->$modelName->setColum();

		if (isset($this->arrayAll['id'])){
			$mID = $this->arrayAll['id'];
			$this->$modelName->setSession('mID', $this->arrayAll['id']);
		}

		$mID = $this->$modelName->getSession('mID');

		if (!$mID){$this->setRedirect('errors');}

		$this->$modelName->addQuery('member_base_id', $mID);


		//リストの取得
		$arraySearch = array();
		if (isset($this->arrayAll['arrayInput'][$modelName])){
			$arraySearch = $this->arrayAll['arrayInput'][$modelName];
		}

		$this->$modelName->limit = $arraySetting['base']['page'];
		$this->$modelName->page = getVar($this->arrayAll, 'page');

		$this->$modelName->target = '*,ext_homework.*';
		$this->$modelName->joinTakeBase();
		list($arrayData, $arrayList) = $this->$modelName->listGetData(getVar($this->arrayAll, 'sortKey'), $arraySearch, getVar($this->arrayAll, 'searchType'));
		$arrayData['arrayList'] = $arrayList;


		//メモの保存
		if (!empty($this->arrayAll['memoHomework'])){
			$arrayDataMember['id'] = $mID;
			$arrayDataMember['memoHomework'] = $this->arrayAll['memoHomework'];
			$this->MemberBase->commit($arrayDataMember);
		}

		//テンプレートで使う変数の設定
		$this->MemberBase->target = '*,member_base.*';
		$this->MemberBase->joinCourceBase();
		$arayMember = $this->MemberBase->getDataUID($mID)->getData();
	


		$this->set('arrayMember', $arayMember);
		$this->set('searchType', $this->$modelName->searchType);
		$this->set('my', '/' . $this->arrayAction['dir'] . $this->arrayAction['a'] . '/');
		$this->set('arrayColum', $this->$modelName->arrayColum);
		$this->set('e', getVar($this->arrayAll, 'e'));
		$this->set('page', $this->$modelName->page);
		$this->set('modelName', $modelName);
		$this->set('arrayData', $arrayData);
		$this->set('arrayInput', $this->$modelName->arrayInput);

		$this->set('arraySettingAdmin', $arraySetting['base']);

?>