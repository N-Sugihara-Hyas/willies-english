<?php

	addModel('ModelDB');

	/*
	*	動画
	*/
	class ExtMovie extends ModelDB{
	var $tableName = 'ext_movie';
	var $order = 'sort ASC';
	}
?>