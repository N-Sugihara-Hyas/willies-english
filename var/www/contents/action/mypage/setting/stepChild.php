<?php
/*
*	初期設定画面2
*/

		//モデル情報の読み込み
		$this->addModel(array('member/Setting'));

		$this->getCommon('first');

		if (!$arrayData = $this->MemberSetting->getSettingStep(5, $this->arrayAll) ){
			$this->setRedirect('mypage/setting/step5/?error=1');
		}

		$this->set('arrayChild', $this->MemberSetting->getFunctionData('LevelChild'));
		$this->set('levelChild', $this->MemberSetting->getSession('levelChild'));


?>