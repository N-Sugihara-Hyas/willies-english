<?php

	if ($_SERVER["SERVER_NAME"] == 'mypage.willies.jp'){
		header('location:/info.html');
		exit();
	}

	/*if (($_SERVER["REMOTE_ADDR"] != '125.193.62.148') && ($_SERVER["REMOTE_ADDR"] != '115.162.31.213')){
		echo '現在新システムに移動中のため２０日（日）14:00 - 17:00の間はご利用頂けません。<br />大変ご迷惑をおかけしますが、17:00以降に改めてアクセスお願い致します。';
		exit();
	}*/

	//コンフィグファイル本体の置いてある場所を指定
	require_once dirname(__FILE__) . '/../config.php';
?>