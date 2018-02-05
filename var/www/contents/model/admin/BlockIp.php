<?php

	addModel('ModelDB');

	/*
	*	管理画面のIP禁止関連のクラス
	*/
	class AdminBlockIp extends ModelDB{
	var $tableName = 'admin_block_ip';
	var $maxCount = 1000;

		function addBlockIP(){
			$this->addQuery('ip',  $_SERVER['REMOTE_ADDR']);
			$this->getData('own');

			$this->arrayData['ip'] = $_SERVER['REMOTE_ADDR'];
			$this->arrayData['count']++;

			$this->commit();
		}

		function isBlockIP(){
			$this->addQuery('ip',  $_SERVER['REMOTE_ADDR']);
			$this->getData('own');

			if ($this->arrayData['count'] >= $this->maxCount){
				return false;
			}

			return true;
		}
	}

?>