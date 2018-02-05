<?php

	addModel('ModelDB');

	/*
	*	講師のメールのクラス
	*/
	class MailTake extends ModelDB{
	var $tableName = 'mail_take';
	var $order = 'sort ASC';

	}
?>