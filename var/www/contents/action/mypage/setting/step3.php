<?php
/*
*	初期設定画面2
*/

		//モデル情報の読み込み
		$this->addModel(array('cource/Style', 'member/Setting', 'setting/Meta'));

		$this->getCommon('first');


		if (!$arrayData = $this->MemberSetting->getSettingStep(2, $this->arrayAll) ){
			$this->setRedirect('mypage/setting/step2/?error=1');
		}
		

		$arrayCourceStyle = $this->CourceStyle->getDataUID($arrayData['csID'])->getData();
		
		if (!$arrayCourceStyle){
			$this->setRedirect('mypage/setting/step2/?error=1');
		}

		if (!$arrayCourceStyle['weekTake']){
			$this->setRedirect('mypage/setting/step2_1/?cource_style_id=' . $this->arrayAll['cource_style_id']);
		}
		
		
		$arrayCource = $this->SettingMeta->getDataCource($arrayData['cID']);
		
		//スタイルが一つしか無い場合は、step1に戻るようにする
		if (count($arrayCource) == 1){
			$this->set('isOwn', 1);
		}

		$arrayWeek = $this->SettingMeta->getDataSchedule($arrayData['csID']);
		$arrayWeek = $this->SettingMeta->changeWeekSort($arrayWeek);
		
		$this->set('error', getVar($this->arrayAll, 'error'));
		$this->set('arraySchdule', $arrayWeek);

?>