<?php

	addModel('ModelDB');

	/*
	*	サプリのクラス
	*/
	class MasterNews extends ModelDB{
	var $tableName = 'master_news';
	var $order = 'dateDay DESC';


	}
?>