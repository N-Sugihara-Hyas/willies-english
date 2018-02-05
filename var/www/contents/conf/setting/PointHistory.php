<?php

		/*
		 * 支払いの取得
		 */
		function getSelectPointHistory($model){
			return array(
				'mypage/action/cancel' => array('id' => 'mypage/action/cancel', 'value' => 'レッスンキャンセルに伴い振替ポイントが１ポイント付与されました'),
				'admin/customer/editEnd' => array('id' => 'admin/customer/editEnd', 'value' => '事務局より振替ポイントが付与されました'),
				'admin/sch/cancel' => array('id' => 'admin/customer/editEnd', 'value' => '事務局より振替ポイントが付与されました'),
				'cron/holidayPoint' => array('id' => 'admin/customer/editEnd', 'value' => '休校に伴い振替ポイントが１ポイント付与されました'),		
				'mypage/return/end' => array('id' => 'admin/customer/editEnd', 'value' => 'ユーザーがポイントを使用しました'),		
				'mypage/pay/end2' => array('id' => 'admin/customer/editEnd', 'value' => 'ユーザーがポイントを購入しました'),		
				'mypage/setting/end2' => array('id' => 'admin/customer/editEnd', 'value' => '新規登録により、１P付与されました'),		
				'cron/lessonPoint' => array('id' => 'admin/customer/editEnd', 'value' => '今週のレッスンポイントが２ポイント付与されました'),		
			);
		}


?>
