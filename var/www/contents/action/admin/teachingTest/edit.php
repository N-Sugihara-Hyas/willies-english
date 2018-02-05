<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		$this->addModel(array('teaching/Test', 'teaching/Base', 'teaching/Lesson'));

		//共通処理
		$this->getCommon();

		$type = getVar($this->arrayAll, 'type');
		$bid = getVar($this->arrayAll, 'bid');
		
		if (!$type){
			$arrayType = $this->TeachingTest->getFunctionData('Teaching');
		}
		if (($type) && (!$bid)){
			$arrayBase = $this->TeachingBase->getCategory($type)->getDataAll();
			
			$this->set('arrayBase', $arrayBase);
		}

		if (($type) && ($bid)){
			$arrayLesson = $this->TeachingLesson->getCategory($type, $bid)->getDataAll();

			$this->set('arrayLesson', $arrayLesson);
		}

		$this->set('bid', $bid);		
		$this->set('type', $type);
		$this->set('arrayType', $arrayType);
?>