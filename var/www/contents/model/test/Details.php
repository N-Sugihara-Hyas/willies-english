<?php

	addModel('ModelDB');

	/*
	*	カードの詳細のクラス
	*/
	class TestDetails extends ModelDB{
	var $tableName = 'test_details';
	var $order = 'test_details.id ASC';
	var $countSelect = 4;

		function joinTestBase(){
			$this->addJoins(array('model' => 'test/Base'));
		}
		function joinTestAnser($mid){
			$this->addJoins(array('model' => 'test/Anser', 'on' => 'test_details.id=test_anser.test_details_id AND test_anser.member_base_id=' . $mid));
		}

		function getBase($mid, $bid){
			$this->target.= ',test_details.*';

			$this->joinTestBase();

			$this->addQuery('test_base_id', $bid);
			
			return $this->getData();
		}



		function getBasePage($tid, $did){
			$this->addQuery($this->tableName . '.id >=', $did);
			$this->addQuery($this->tableName . '.test_base_id', $tid);

			return $this->getData();
		}

		function getBaseBack($tid, $did){
			$this->order = 'test_details.id DESC';
			$this->addQuery($this->tableName . '.id <', $did);
			$this->addQuery($this->tableName . '.test_base_id', $tid);

			return $this->getData();
		}
		function getBaseNext($tid, $did){
			$this->order = 'test_details.id ASC';
			$this->addQuery($this->tableName . '.id >', $did);
			$this->addQuery($this->tableName . '.test_base_id', $tid);

			return $this->getData();
		}

		function getAnser(){
			return $this->getSession('anser');
		}
		function setAnser($arrayData){
			return $this->setSession('anser', $arrayData);
		}

		function changeAnser($arrayData){
			$this->setSession('anser', array());
			$this->setSession('anserStatic', $arrayData);
		}
		function getAnserStatic(){
			return $this->getSession('anserStatic');
		}
	}
?>