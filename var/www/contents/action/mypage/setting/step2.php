<?php
/*
*	初期設定画面2
*/

		//モデル情報の読み込み
		$this->addModel(array('setting/Meta', 'member/Setting'));

		//$this->isFirstNg = true;
		$this->getCommon('first');

		if (!$arrayData = $this->MemberSetting->getSettingStep(1, $this->arrayAll) ){
			$this->setRedirect('mypage/setting/first/?error=1');
		}
				
		
		$arrayCource = $this->SettingMeta->getDataCource($arrayData['cID']);


		if (!$arrayCource){
			$this->setRedirect('mypage/setting/first/?error=1');
		}
		
		//スタイルが一つしか無いコースは強制的にそれに決まる。
		if (count($arrayCource) == 1){
			$this->setRedirect('mypage/setting/step3/?cource_style_id=' . $arrayCource[0]['value']);
		}

		$this->set('error', getVar($this->arrayAll, 'error'));
		$this->set('arrayCource', $arrayCource);

?>