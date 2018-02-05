<?php

	/*
	*	支払いの無い人間のコースのキャンセルの処理
	*/
	$this->addModel(array('admin/User'));
		
		ini_set('display_errors', 'On');
		error_reporting(E_ALL);

	$filePath = "保存する場所への絶対パス";
	$fileName = date('ymd').'_'.date('His').'.sql';
	$command = 'mysqldump -h ' .db_host . ' -u ' . db_user . ' -p' . db_pass . ' --ignore-table=' . db_db . '.media_image ' . db_db . ' --lock-tables=false > '.$this->arrayDir['dirContents'] . 'backup/sql/' . date('d') . '.sql';
	system($command, $arrayLog);

	exit();
		
?>