<?php
/*
*	ピンポイントのレッスン予約2
*/
		//モデル情報の読み込み
		$this->addModel(array('cource/Base', 'member/Reserve', 'cource/Style', 'member/Base', 'take/Base', 'take/Schedule'));

		$this->getCommon();
		if ($this->arrayUser['dateTestDaily']){$this->setRedirect('errors');}

		//指定した情報の保存
		$arrayDate = $this->MemberBase->getSession('schedule');

		$arrayDate[1]['time'] = $this->arrayAll['time'];
		$arrayDate[1]['date'] = $this->arrayAll['date'];
		$arrayDate[1]['tID'] = $this->arrayAll['tID'];
		$this->MemberBase->setSession('schedule', $arrayDate);

		$arrayCource = $this->MemberBase->getSession('cource');
		$cID = $arrayCource['cource_base_daily_id'];


		//講師情報の取得
		foreach ($arrayDate as $key => $item){
			$arrayDate[$key]['arrayTake'] = $this->TakeBase->getDataUID($item['tID'])->getData();
		}
		

		$this->set('title', 'グループ音読レッスン 登録');
		$this->set('arrayDate', $arrayDate);

		

?>