<?php

	addModel('ModelDB');

	/*
	*	サプリのクラス
	*/
	class CompanyBase extends ModelDB{
	var $tableName = 'company_base';
	var $tableNameSession = 'company_session';
	var $loginID = 'company_base_id';
	var $dateLastLogin = 'dateLastLogin';
	}

?>