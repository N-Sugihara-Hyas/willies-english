<?php

		/*
		 * メンバーのステータス(グループ)の取得
		 */
		function getSelectMemberStateDaily($model){
			return array(
				'0' => array('id' => '0', 'value' => '1.-', 'valueEn' => '1.-'),
				'1' => array('id' => '1', 'value' => '2. Tial Student', 'valueEn' => '2. Tial Student'),
				'2' => array('id' => '2', 'value' => '3. Finish Trial', 'valueEn' => '3. Finish Trial'),
				'3' => array('id' => '3', 'value' => '4. Regular', 'valueEn' => '4. Regular'),
				'4' => array('id' => '4', 'value' => '5. Dropped out', 'valueEn' => '5. Dropped out'),
			);
		}

?>
