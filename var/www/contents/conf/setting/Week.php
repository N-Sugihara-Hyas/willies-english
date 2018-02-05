<?php

		/*
		 * 曜日の取得
		 */
		function getSelectWeek($model){
			return array(
				'1' => array('id' => '1', 'value' => '月', 'en' => 'Mon'),
				'2' => array('id' => '2', 'value' => '火', 'en' => 'Tue'),
				'3' => array('id' => '3', 'value' => '水', 'en' => 'Web'),
				'4' => array('id' => '4', 'value' => '木', 'en' => 'Thu'),
				'5' => array('id' => '5', 'value' => '金', 'en' => 'Fri'),
				'6' => array('id' => '6', 'value' => '土', 'en' => 'Sat'),
				'0' => array('id' => '0', 'value' => '日', 'en' => 'Sun'),
			);
		}

?>
