<?php

	addModel('ModelDB');

	/*
	*	宿題
	*/
	class ExtHomework extends ModelDB{
	var $tableName = 'ext_homework';

		function joinTakeBase(){
			$this->addJoins(array('model' => 'take/Base'));
		}
		
		function getTarget($objData){
			$this->addQuery('date', $objData['date']);
			$this->addQuery('member_base_id', $objData['member_base_id']);
			
			return $this->getData();
		}
		
		function getTeaching($objItem){			
			$TeachingBase = $this->getModel('teaching/Base');
			$TeachingLesson = $this->getModel('teaching/Lesson');
			
			$arrayType = $this->getFunctionData('Teaching');
						
			foreach ($arrayType as $book){
				if ($objItem['home' . $book['value']]){
					$objData = $TeachingBase->getDataUID($objItem['home' . $book['value']])->getData();
					$objItem['home' . $book['value']] = $objData['teachingName'];
					$objData = $TeachingLesson->getDataUID($objItem['lesson' . $book['value']])->getData();
					$objItem['lesson' . $book['value']] = $objData['lessonName'];

				}
			}
			
			return $objItem;
		}
		
	}
?>