<?php

		/*
		 * 問合せのカテゴリの取得
		 */
		function getSelectContactType($model){			
			return array(
				'1' => array('id' => '1', 'value' => '1. 無料体験レッスンについて'),
				'2' => array('id' => '2', 'value' => '2. スケジュールの変更、講師の変更について'),
				'3' => array('id' => '3', 'value' => '3. 受講コースの変更について'),
				'4' => array('id' => '4', 'value' => '4. 講師について'),
				'5' => array('id' => '5', 'value' => '5. レッスンの内容・進め方について'),
				'6' => array('id' => '6', 'value' => '6. レッスンのキャンセル、振替レッスンについて'),
				'7' => array('id' => '7', 'value' => '7. Weekly Feedbackについて'),
				'8' => array('id' => '8', 'value' => '8. お支払いについて'),
				'9' => array('id' => '9', 'value' => '9. 退会、休会について'),
				'10' => array('id' => '10', 'value' => '10. その他'),
			);
		}


?>
