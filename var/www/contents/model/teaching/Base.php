<?php

	addModel('ModelDB');

	/*
	*	テストのクラス
	*/
	class TeachingBase extends ModelDB{
	var $tableName = 'teaching_base';
	var $order = 'teaching_base.sort DESC';

		function getCategory($type){
			$this->addQuery('category LIKE', '%"' . $type . '"%');			
			return $this->getData();
		}
	}
?>