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
		$this->$modelName->limit = 1000;
		$this->$modelName->page = getVar($this->arrayAll, 'page');
				
		$this->set('arrayTime', $this->TakeSchedule->getArrayTime());
		$this->set('week', getVar($this->arrayAll, 'week'));
		$this->set('time', getVar($this->arrayAll, 'time'));


		list($arrayData, $arrayList) = $this->$modelName->listGetData();
		
		$arrayResult = array();
		
		$dateStart = getVar($this->arrayAll, 'dateStart');
		$dateEnd = getVar($this->arrayAll, 'dateEnd');
		
		if (!$dateStart){$dateStart = date('Y-m') . '-01';}
		if (!$dateEnd){$dateEnd = date('Y-m-d');}

		while ($item = $arrayList->getData()){
			$arrayResult[$item['id']] = $item;
			$arrayResult[$item['id']]['arrayAllowance'] = $this->$modelName->getAllowance($item, $dateStart, $dateEnd);
		}
		$arrayData['arrayList'] = $arrayResult;
		
		if (isset($this->arrayAll['csv'])){
			echo mb_convert_encoding('講師ID,ニックネーム,契約就労時間(hr),就労時間(hr),レギュラーレッスン(回),振替レッスン(回),グループ音読レッスン(回),その他(回),レギュラー生徒化人数 (人),4ヶ月継続生徒 (人)', 'SJIS', 'UTF-8');
			
			foreach ($arrayResult as $item){
				echo "\n";
				
				echo $item['id'];
				foreach ($item['arrayAllowance'] as $item2){
					echo ',' . $item2;
				}
			}
			exit();			
		}
		//テンプレートで使う変数の設定
		$this->set('searchType', $this->$modelName->searchType);
		$this->set('arrayColum', $this->$modelName->arrayColum);
		$this->set('e', getVar($this->arrayAll, 'e'));
		$this->set('page', $this->$modelName->page);
		$this->set('modelName', $modelName);
		$this->set('arrayData', $arrayData);
		$this->set('arrayInput', $this->$modelName->arrayInput);

		$this->set('dateStart', $dateStart);
		$this->set('dateEnd', $dateEnd);

		$this->set('arraySettingAdmin', $arraySetting['base']);

?>