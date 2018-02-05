<?php

	/*
	*	支払いの無い人間のコースのキャンセルの処理
	*/
	$this->addModel(array('take/ReserveAll'));
	
	$this->TakeReserveAll->clear();
	
	echo 'データを消去しました';

	exit();
		
?>