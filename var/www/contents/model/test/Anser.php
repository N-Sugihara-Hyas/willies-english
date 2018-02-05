<?php

	addModel('ModelDB');

	/*
	*	カードの正解のクラス
	*/
	class TestAnser extends ModelDB{
	var $tableName = 'test_anser';

		function getMy($mid, $did){
			$this->addQuery('test_anser.member_base_id', $mid);
			$this->addQuery('test_anser.test_details_id', $did);

			return $this->getData();
		}


	}
?>