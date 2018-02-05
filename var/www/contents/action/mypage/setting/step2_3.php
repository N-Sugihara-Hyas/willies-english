<?php
/*
*	初期設定画面2_2
*/

		//モデル情報の読み込み
		$this->addModel(array('cource/Base', 'cource/Style', 'member/Setting', 'setting/Meta', 'take/Base', 'take/Schedule'));

		$this->getCommon('first');

		if (!$arrayData = $this->MemberSetting->getSettingStep(2, $this->arrayAll)){
			$this->setRedirect('mypage/setting/step2_2/?error=1');
		}
		if (!$arrayData2 = $this->MemberSetting->getSettingStep2(2, $this->arrayAll)){
			$this->setRedirect('mypage/setting/step2_2/?error=1');
		}

		//print_r($this->CourceStyle->getDataUID($arrayData['csID'])->getData());
		
		$this->set('arrayTake', $this->TakeBase->getDataUID($arrayData2['tID'])->getData());
		$this->set('arrayCourceBase', $this->CourceBase->getDataUID($arrayData['cID'])->getData());
		$this->set('arrayCourceStyle', $this->CourceStyle->getDataUID($arrayData['csID'])->getData());

		//if (!$this->arrayUser['isSetting']){
			$this->set('arrayDate', $arrayData2);
		//}
		

?>