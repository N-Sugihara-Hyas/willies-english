<?php

	addModel('ModelDB');

	/*
	*	テストのクラス
	*/
	class TeachingHomeworkCard extends ModelDB{
	var $tableName = 'teaching_card';
	var $order = 'teaching_card.id DESC';

		function getHomework($hid){
			$this->addQuery('teaching_homework_id', $hid);
			
			return $this->getData();			
		}

	}
?>