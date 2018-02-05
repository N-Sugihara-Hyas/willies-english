<?php

	addModel('ModelDB');

	/*
	*	テストのクラス
	*/
	class TestHistory extends ModelDB{
	var $tableName = 'test_history';

		function joinTestBase(){
			$this->addJoins(array('model' => 'test/Base'));
		}

		function getMyBase($mid, $tid){
			$this->addQuery('member_base_id', $mid);
			$this->addQuery('test_base_id', $tid);

			return $this->getData();
		}
	}
?>