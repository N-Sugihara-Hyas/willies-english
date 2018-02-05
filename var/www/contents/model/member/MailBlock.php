<?php

	addModel('ModelDB');

	/*
	*	メールブロック
	*/
	class MemberMailBlock extends ModelDB{
	var $tableName = 'member_mail_block';

		function getMemberType($mid, $type){
			$this->addQuery('member_base_id', $mid);
			$this->addQuery('type', $type);
			
			return $this->getData();
		}
	}
	
?>