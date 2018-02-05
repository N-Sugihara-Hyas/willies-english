<?php

		/*
		 * どこでしったかの取得
		 */
		function getSelectSearch($model){
			return array(
				'0' => array('id' => '0', 'value' => "未選択"),
				'1' => array('id' => '1', 'value' => 'ネットの比較サイト'),
				'2' => array('id' => '2', 'value' => 'キーワード検索（GoogleやYahooなどでの検索）'),
				'8' => array('id' => '8', 'value' => 'Facebookキャンペーン'),
				'4' => array('id' => '4', 'value' => 'ネットの口コミサイト'),
				'6' => array('id' => '6', 'value' => '友人などからの紹介'),
				'5' => array('id' => '5', 'value' => '新聞・雑誌'),
				'7' => array('id' => '7', 'value' => 'その他'),
			);
		}


?>
