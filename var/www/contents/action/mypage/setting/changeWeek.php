<?php
/*
*	曜日変更
*/

		//モデル情報の読み込み
		$this->addModel(array('cource/Style', 'member/Setting', 'setting/Meta'));

		$this->getCommon();

		$this->MemberSetting->setSession('trialout', '');
				

		if (!$this->MemberSetting->getSettingStep(2, $this->arrayUser)){
			$this->setRedirect('mypage');
		}

		$arrayCourceStyle = $this->CourceStyle->getDataUID($this->arrayUser['cource_base_id'])->getData();

		$this->set('objTake', '');
		$this->set('returnTake', '');

		if ($this->arrayAll['tid']){
			$objTake = $this->TakeBase->getDataUID($this->arrayAll['tid'])->getData();			
			$this->set('objTake', $objTake);
			$this->set('returnTake', 'setting/changeWeek');
		}else{
			$this->TakeBase->addQuery('isView', 1);
			$arrayTakeAll = $this->TakeBase->getData()->getDataAll();
			$this->set('arrayTakeBaseAll', $arrayTakeAll);
		}
		
		$this->set('error', getVar($this->arrayAll, 'error'));		
		$this->set('arraySchdule', $this->SettingMeta->sortWeek($this->SettingMeta->getDataSchedule($this->arrayUser['cource_style_id'])));

?>