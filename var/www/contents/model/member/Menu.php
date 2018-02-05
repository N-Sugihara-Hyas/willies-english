<?php

	addModel('ModelDB');

	/*
	*	Admin Menuのクラス
	*/
	class MemberMenu extends ModelDB{
	var $tableName = 'member_menu';
	var $order = 'sort ASC';

	}
?>