<?php

	addModel('ModelDB');

	/*
	*	講師のキャンセルのクラス(生徒の履歴に関係無し版)
	*/
	class TakeCancel extends ModelDB{
	var $tableName = 'take_cancel';

		function copy($rid){
			$TakeReserve = $this->getModel('take/Reserve');
			$arrayReserve = $TakeReserve->getDataUID($rid)->getData();

			$this->addData($arrayReserve);
		}
	}
?>