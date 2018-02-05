<?php

		/*
		 * メンバーのステータスの取得
		 */
		function getSelectMemberState($model){
			return array(
				'0' => array('id' => '0', 'value' => '1. Applied', 'valueEn' => '1.Applied'),
				'1' => array('id' => '1', 'value' => '2.Trial Student', 'valueEn' => '2. Trial Student'),
				'2' => array('id' => '2', 'value' => '3. Finish Trial', 'valueEn' => '3. Finish Trial'),
				'3' => array('id' => '3', 'value' => '4. Regular', 'valueEn' => '4. Regular'),
				'10' => array('id' => '10', 'value' => '5. Dropped out', 'valueEn' => '5. Dropped out'),
				'11' => array('id' => '11', 'value' => '6. Dropped out(一時的)', 'valueEn' => '6. Dropped out(一時的)'),
			);
		}

?>
