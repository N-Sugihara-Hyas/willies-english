<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName'], 'teaching/Lesson', 'teaching/Homework', 'teaching/Test'));
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

		list($arrayData, $arrayList) = $this->$modelName->listGetData(getVar($this->arrayAll, 'sortKey'), $arraySearch, getVar($this->arrayAll, 'searchType'));
		
		$arrayResult = array();
		while ($objList = $arrayList->getData()){
			$arrayCategory = json_decode($objList['category']);
			
			foreach ($arrayCategory as $category){			
				$objList['category'] = json_encode(array($category => $category));

				$this->TeachingLesson->addQuery('category LIKE', '%"' . $category . '"%');				
				$this->TeachingLesson->addQuery('teaching_base_id', $objList['id']);
				$objList['arrayLesson'] = $this->TeachingLesson->getData()->getDataAll();
				
				foreach ($objList['arrayLesson'] as $key => $objLesson){
					$this->TeachingHomework->addQuery('category', $category);
					$this->TeachingHomework->addQuery('teaching_base_id', $objList['id']);
					$this->TeachingHomework->addQuery('teaching_lesson_id', $objLesson['id']);
					
					$objList['arrayLesson'][$key]['objHomework'] = $this->TeachingHomework->getData()->getData();
					
					$this->TeachingTest->addQuery('category', $category);
					$this->TeachingTest->addQuery('teaching_base_id', $objList['id']);
					$this->TeachingTest->addQuery('teaching_lesson_id', $objLesson['id']);
					$objList['arrayLesson'][$key]['objTest'] = $this->TeachingTest->getData()->getData();
					
					//print_r($objLesson);
				}
				
				//レッスン情報
				array_push($arrayResult, $objList);
			}
		}
		
		$arrayData['arrayList'] = $arrayResult;

		$this->$modelName->arrayColum['category']['type'] = 'select';
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

?>