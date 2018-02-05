<?php

	/***********************************************************
	 * 画像の表示
	 */

		$this->addModel(array('take/Reserve', 'member/Setting'));

		if (!$arrayData = $this->MemberSetting->getSettingStep(2, $this->arrayAll) ){
			$this->setRedirect('mypage/setting/step2/?error=1');
		}

		if ($this->TakeReserve->getDataDate($arrayData['cID'], $this->uid, 50, 1)){
			echo $this->uid . ',' . $this->arrayAll['out'];
		}
		
		exit();
?>
