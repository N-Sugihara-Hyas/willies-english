<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		$this->addModel(array('teaching/Homework', 'teaching/Base', 'teaching/Lesson', 'teaching/HomeworkCard'));

		//共通処理
		$this->getCommon();
		


		if (!$this->uid){
			$type = getVar($this->arrayAll, 'type');
			$bid = getVar($this->arrayAll, 'bid');
			$lid = getVar($this->arrayAll, 'lid');
			
			$objData['category'] = $type;
			$objData['teaching_base_id'] = $bid;
			$objData['teaching_lesson_id'] = $lid;
			
			$uid = $this->TeachingHomework->commit($objData);
			
			$this->setRedirect('teachingHomework/end/' . $uid . '/');
		}		
		
		$objHomework = $this->TeachingHomework->getDataUID($this->uid)->getData();
		
		$arrayType = $this->TeachingHomework->getFunctionData('Teaching');
		$objType = $arrayType[$objHomework['category']];
		$objBase = $this->TeachingBase->getDataUID($objHomework['teaching_base_id'])->getData();
		$objLesson = $this->TeachingLesson->getDataUID($objHomework['teaching_lesson_id'])->getData();
		
		if ($objType['id'] == 2){

			$count = $this->TeachingHomework->addQuery('id', $this->uid);
			$count = $this->TeachingHomework->addQuery('body IS NOT NULL');
			$count = $this->TeachingHomework->getDataUID($this->uid)->getCount();
			$this->set('count', $count);
			
		}else{
			$count = $this->TeachingHomeworkCard->getHomework($this->uid)->getCount();
			$this->set('count', $count);
		}
		
		$this->set('objType', $objType);
		$this->set('objBase', $objBase);
		$this->set('objLesson', $objLesson);
		$this->set('uid', $this->uid);

?>