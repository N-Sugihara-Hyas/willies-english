<?php

	addModel('ModelDB');

	/*
	*	講師のメッセージのクラス
	*/
	class TakeMessageOpen extends ModelDB{
	var $tableName = 'take_message_open';
	var $group = '*';
	var $order = 'to_id DESC';

		function setOpen($uid, $mid){
			if (!$this->getOpen($uid, $mid)->getData()){
				$arrayData['take_message_id'] = $uid;
				$arrayData['to_id'] = $mid;

				$this->commit($arrayData);
			}
		}
		function getOpen($uid, $mid){
			$this->addQuery('take_message_id', $uid);
			$this->addQuery('to_id', $mid);

			return $this->getData();
		}

	}
?>