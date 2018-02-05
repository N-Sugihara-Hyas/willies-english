<?php

		/*
		 * 管理者のお知らせの取得
		 */
		function getSelectAdminNewsType($model){
			return array(
				'4' => array('id' => 4, 'value' => '【WiLLies English】New Applicant Information'),
				'6' => array('id' => 6, 'value' => '【WiLLies English】New Trial Student information (Plan ({$planType}))'),
				'9' => array('id' => 9, 'value' => '【WiLLies English】New Regular Student!!! (Plan ({$planType}))'),
				'11' => array('id' => 11, 'value' => '【WiLLies English】Lesson was canceled'),
				'13' => array('id' => 13, 'value' => '【WiLLies English】Substitute lesson information'),
				'15' => array('id' => 15, 'value' => '【WiLLies English】Student schedule was changed'),
				'17' => array('id' => 17, 'value' => '【WiLLies English】Weekly Feedback was created by a student'),
				'19' => array('id' => 19, 'value' => '【WiLLies English】生徒様からお問合せフォームが届きました。'),
				'21' => array('id' => 21, 'value' => '【WiLLies English】生徒様からレッスン評価フォームが届きました。'),
				'23' => array('id' => 23, 'value' => '【WiLLies english】Your schedule has been changed by manager'),
				'28' => array('id' => 28, 'value' => '【WiLLies English】lesson information (Pattern B)'),
				'35' => array('id' => 35, 'value' => 'You have a trial lesson today with ID ({$member_base_id})'),
				'43' => array('id' => 43, 'value' => '【WiLLies English】New Trial Student information (Plan ({$planType}))'),
				'44' => array('id' => 44, 'value' => '【WiLLies English】New Regular Student!!! (Plan ({$planType}))'),
				'51' => array('id' => 51, 'value' => '	Textbook Request　(ID({$id}))'),
			);
		}


?>
