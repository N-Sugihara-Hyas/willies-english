<?php

	addModel('ModelDB');

	/*
	*	テストのクラス
	*/
	class TeachingLesson extends ModelDB{
	var $tableName = 'teaching_lesson';
	var $order = 'teaching_lesson.sort DESC';

		function getCategory($type='', $bid=''){
			$this->addJoins(array('model' =>'teaching/Base'));
			
			if ($type){
				$this->addQuery('teaching_base.category LIKE', '%"' . $type . '"%');			
			}
			
			if ($bid){
				$this->addQuery('teaching_base.id', $bid);			
			}
			
			return $this->getData();
		}
	}
?>