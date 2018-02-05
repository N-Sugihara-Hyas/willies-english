<?php

	
	//モデル情報の読み込み
	$this->addModel(array('cource/Style', 'take/Schedule', 'cource/Base', 'member/Base', 'master/AdminNews', 'member/Setting'));
	$this->addLiblary(array('tool/Paypal'));

	$this->getCommon();
				
	$arrayCourceStyle = $this->CourceStyle->getDataUID($this->arrayUser['cource_style_id'])->getData();
	
	
		//メールの送信
		//$this->MasterAdminNews->sendMailPay(1, $this->arrayUser, $arrayCourceStyle);

		//支払処理
		$this->MemberBase->setPay($this->arrayUser['id'], $type);
		

?>