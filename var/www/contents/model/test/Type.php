<?php

	addModel('ModelDB');

	/*
	*	テストのクラス
	*/
	class TestType extends ModelDB{
	var $tableName = 'test_type';
	var $order = 'test_type.created DESC';

		function getCourceBase($cid){
			$this->addQuery('cource_base_id', $cid);
			$this->addQuery('OR cource_base_id', 0);

			return $this->getData();
		}
	}
?>