<?php

	addModel('ModelDB');

	/*
	*	マンスリーフィードバック
	*/
	class ExtMonthly extends ModelDB{
	var $tableName = 'ext_monthly';

		function joinTakeBase(){
			$this->addJoins(
				array('model' => 'take/Base')
			);
		}
	}
?>