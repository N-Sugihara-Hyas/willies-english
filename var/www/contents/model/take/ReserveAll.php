<?php

	require_once 'Reserve.php';
	
	/*
	*	講師の予約状況のクラス
	*/
	class TakeReserveAll extends TakeReserve{
	var $tableName = 'take_reserve_all';
	var $order = 'date ASC,take_reserve_all.timeStart ASC';
	
	}
?>