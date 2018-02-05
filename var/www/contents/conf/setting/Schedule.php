<?php

		/*
		 * コースの取得
		 */
		function getSelectSchedule($model){
			return array(
				'1' => array('id' => '1', 'value' => '月・木', 'valueEnglish' => 'Mon/Thu', 'week' => '1,4'),
				'2' => array('id' => '2', 'value' => '火・金', 'valueEnglish' => 'Tun/Fri', 'week' => '2,5'),
				'3' => array('id' => '3', 'value' => '土・日', 'valueEnglish' => 'Sat/Sun', 'week' => '6,0'),
				'5' => array('id' => '5', 'value' => '月', 'valueEnglish' => 'Sun', 'week' => '1'),
				'6' => array('id' => '6', 'value' => '火', 'valueEnglish' => 'Sun', 'week' => '2'),
				'4' => array('id' => '4', 'value' => '水', 'valueEnglish' => 'Wed', 'week' => '3'),
				'7' => array('id' => '7', 'value' => '木', 'valueEnglish' => 'Sun', 'week' => '4'),
				'8' => array('id' => '8', 'value' => '金', 'valueEnglish' => 'Sun', 'week' => '5'),
				'9' => array('id' => '9', 'value' => '土', 'valueEnglish' => 'Sat', 'week' => '6'),
				'10' => array('id' => '10', 'value' => '日', 'valueEnglish' => 'Sun', 'week' => '0'),
			);
		}

?>
