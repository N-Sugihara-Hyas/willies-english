<?php
/*
*	初期設定画面
*/

		//モデル情報の読み込み
		$this->addModel(array('member/CancelTrial', 'take/Reserve', 'master/AdminNews'));

		$this->getCommon();

		$this->TakeReserve->arrayData = $this->TakeReserve->getDataUID($this->uid)->getData();

		if (!$this->MemberCancelTrial->setCancel($this->uid, $this->arrayUser['id'])){
			$this->setShow('cancelError');
		}


		//メールなどの送付
		$this->MasterAdminNews->sendMailCancel($this->arrayUser, $this->TakeReserve->arrayData);

?>