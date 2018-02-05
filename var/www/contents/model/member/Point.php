<?php

	addModel('ModelDB');

	/*
	*	振替ポイント履歴のクラス
	*/
	class MemberPoint extends ModelDB{
	var $tableName = 'member_point';
	var $tID ='';

		function addPoint($arrayData){
			$arrayData2['point'] = $arrayData['countReturn'];
			$arrayData2['member_base_id'] = $arrayData['id'];
			$arrayData2['action'] = $this->arrayAction['dir'] . $this->arrayAction['a'];
			$this->commit($arrayData2);
		}

	}
	
?>