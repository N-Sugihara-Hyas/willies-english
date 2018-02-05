<?php

	addModel('ModelDB');

	/*
	*	Admin Menuのクラス
	*/
	class MasterMenu extends ModelDB{
	var $tableName = 'master_menu';
	var $order = 'sort ASC';

	}
?>