<?php

	addModel('ModelDB');

	/*
	*	講師の席に着いたかのチェック
	*/
	class TakeUpdate extends ModelDB{
	var $tableName = 'take_update';
	var $order = 'dateTime DESC';
	var $group = '*';

		/*
		*	講師情報のジョイント
		*/
		function joinTakeBase(){
			$this->addJoins(
				array('model' => 'take/Base')
			);
		}

	}
?>