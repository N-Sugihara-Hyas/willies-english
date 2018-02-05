<?php

	addModel('ModelDB');

	/*
	*	宿題の資料
	*/
	class ExtHomeworkBook extends ModelDB{
	var $tableName = 'ext_homework_book';

		function getDataType($type){
			$this->addQuery('type', $type);
			return $this->getData();
		}
	}
?>