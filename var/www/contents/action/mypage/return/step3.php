<?php
/*
*	ピンポイントのレッスン予約2
*/
		//モデル情報の読み込み
		$this->addModel(array('cource/Base', 'member/Reserve', 'cource/Style', 'member/Setting', 'take/Base', 'take/Schedule'));

		$this->getCommon();

		//指定した情報の保存とチェック
		if (!$arrayData2 = $this->MemberSetting->getSettingStep2(2, $this->arrayAll)){
			$this->setRedirect('mypage/setting/step2_1/?error=1');
		}


		$cID =$this->arrayUser['cource_base_id'];
		$csID =$this->arrayUser['cource_style_id'];

		$arrayCourceStyle = $this->CourceStyle->getDataUID($csID)->getData();

		//その予約が可能かの判定
		if (!$title = $this->MemberReserve->isReserveType($this->arrayUser, getVar($this->arrayAll, 'type'), $arrayCourceStyle)){
			$this->setRedirect('errors');
		}
		
		//講師情報の取得
		$arrayTake = $this->TakeBase->getDataUID($arrayData2['tID'])->getData();

		if (!$arrayTake){
			$this->setRedirect('errors');
		}

		$this->set('arrayTake', $arrayTake);
		$this->set('title', $title);
		$this->set('arrayDate', $arrayData2);
		$this->set('type', $this->arrayAll['type']);
		$this->set('op', getVar($this->arrayAll, 'op'));
		$this->set('arrayTake', $arrayTake);

		

?>