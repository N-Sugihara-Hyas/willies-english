<?php

		/*
		 * 管理者の言語種別の取得
		 */
		function getSelectActing($model){
			return array(
				'1' => array('id' => '1', 'value' => '他の先生による代講を希望する'),
				'0' => array('id' => '0', 'value' => '振替レッスンポイントを希望する'),
			);
		}


?>
