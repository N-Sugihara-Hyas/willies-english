<?php
/*
*	スケジュールの再確保
*/

		//モデル情報の読み込み
		$this->addModel(array('cource/Style', 'member/Setting', 'setting/Meta'));

		$this->getCommon();
				

			
		if (($this->arrayUser['state'] != 2) && ($this->arrayUser['state'] != 11) && ($this->arrayUser['state'] != 10)){
			$this->setRedirect('mypage');
		}

		/*if (!$this->MemberSetting->getSettingStep(2, $this->arrayUser)){
			$this->setRedirect('mypage');
		}*/

		$arrayCourceStyle = $this->CourceStyle->getDataUID($this->arrayUser['cource_base_id'])->getData();

		//トライアルエンドのフラグ
		$this->MemberSetting->setSession('trialout', 'setting/end');

		$this->setRedirect('mypage/setting/first');
//		$this->set('error', getVar($this->arrayAll, 'error'));
//		$this->set('arraySchdule', $this->SettingMeta->getDataSchedule($this->arrayUser['cource_style_id']));

?>