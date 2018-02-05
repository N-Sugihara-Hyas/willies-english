<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		$this->addModel(array('teaching/Test', 'teaching/Base', 'teaching/Lesson', 'teaching/TestCard'));

		//共通処理
		$this->getCommon();
		


		if (!$this->uid){
			$type = getVar($this->arrayAll, 'type');
			$bid = getVar($this->arrayAll, 'bid');
			$lid = getVar($this->arrayAll, 'lid');

			$objData['category'] = $type;
			$objData['teaching_base_id'] = $bid;
			$objData['teaching_lesson_id'] = $lid;
			
			$uid = $this->TeachingTest->commit($objData);
			
			$this->setRedirect('teachingTest/end/' . $uid . '/');
		}		
		
		$objTest = $this->TeachingTest->getDataUID($this->uid)->getData();
		
		$arrayType = $this->TeachingTest->getFunctionData('Teaching');
		$objType = $arrayType[$objTest['category']];
		$objBase = $this->TeachingBase->getDataUID($objTest['teaching_base_id'])->getData();
		$objLesson = $this->TeachingLesson->getDataUID($objTest['teaching_lesson_id'])->getData();

		if ($objType['id'] == 2){
			$count = $this->TeachingTest->getDataUID($this->uid)->getCount();
			$this->set('count', $count);
			
		}else{
			$count = $this->TeachingTestCard->getTest($this->uid)->getCount();
			$this->set('count', $count);
		}
		
		$this->set('objType', $objType);
		$this->set('objBase', $objBase);
		$this->set('objLesson', $objLesson);
		$this->set('uid', $this->uid);

?>