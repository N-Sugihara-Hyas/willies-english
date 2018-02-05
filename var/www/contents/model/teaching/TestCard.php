<?php

	addModel('ModelDB');

	/*
	*	テストのクラス
	*/
	class TeachingTestCard extends ModelDB{
	var $tableName = 'teaching_test_card';
	var $order = 'teaching_test_card.id DESC';

		function getTest($hid){
			$this->addQuery('teaching_test_id', $hid);
			
			return $this->getData();			
		}

	}
?>