<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName'], 'take/MessageOpen'));
		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];

		//共通処理
		$this->getCommon();

		//リストの設定
		$this->$modelName->addModelTool('List');
		$this->$modelName->isSort = $arraySetting['base']['isSort'];
		$this->$modelName->isSearch = $arraySetting['base']['isSearch'];

		$this->$modelName->setColum();

		$this->$modelName->target = '*,take_message.*';
		//$this->$modelName->joinTakeMessageOpen(-1);

		if (empty($this->arrayAll['sent'])){
			$this->$modelName->joinTakeBaseFrom();
			$this->$modelName->addQuery('take_message.to_id', '-1');
		}else{
			$this->$modelName->joinTakeBaseTo();
			$this->$modelName->addQuery('take_message.from_id', '-1');
		}

		//リストの取得
		$arraySearch = array();
		if (isset($this->arrayAll['arrayInput'][$modelName])){
			$arraySearch = $this->arrayAll['arrayInput'][$modelName];
		}

		$this->$modelName->limit = $arraySetting['base']['page'];
		$this->$modelName->page = getVar($this->arrayAll, 'page');

		$this->$modelName->addQuery("message <> ''");

		list($arrayData, $arrayList) = $this->$modelName->listGetData(getVar($this->arrayAll, 'sortKey'), $arraySearch, getVar($this->arrayAll, 'searchType'));

		$arrayList2 = array();		
		while ($objData = $arrayList->getData()){
			$objOpen = $this->TakeMessageOpen->getOpen($objData['id'], -1)->getData();
			$objData['take_message_id'] = false;

			if ($objOpen){
				$objData['take_message_id'] = true;
			}
							
			array_push($arrayList2, $objData); 	
		}
		
		$arrayData['arrayList'] = $arrayList2;

		//テンプレートで使う変数の設定
		$this->set('searchType', $this->$modelName->searchType);
		$this->set('my', '/' . $this->arrayAction['dir'] . $this->arrayAction['a'] . '/');
		$this->set('arrayColum', $this->$modelName->arrayColum);
		$this->set('e', getVar($this->arrayAll, 'e'));
		$this->set('page', $this->$modelName->page);
		$this->set('modelName', $modelName);
		$this->set('arrayData', $arrayData);
		$this->set('arrayInput', $this->$modelName->arrayInput);

		$this->set('sent', getVar($this->arrayAll, 'sent'));
		$this->set('plusNavi', 'sent=' . getVar($this->arrayAll, 'sent'));
		$this->set('arraySettingAdmin', $arraySetting['base']);

?>