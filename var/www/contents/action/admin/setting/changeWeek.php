<?php
/*
*	曜日変更
*/

		//モデル情報の読み込み
		$this->addModel(array('cource/Style', 'member/Setting', 'setting/Meta'));

		$this->getCommon();

		if (!$this->arrayUser['isPay']){
			$this->setRedirect('mypage');
		}

		if (!$this->MemberSetting->getSettingStep(2, $this->arrayUser)){
			$this->setRedirect('mypage');
		}

		$arrayCourceStyle = $this->CourceStyle->getDataUID($this->arrayUser['cource_base_id'])->getData();

		$this->set('error', getVar($this->arrayAll, 'error'));
		$this->set('arraySchdule', $this->SettingMeta->getDataSchedule($this->arrayUser['cource_style_id']));

?>