<?php
/*
*	初期設定画面
*/

		//モデル情報の読み込み
		$this->addModel(array('member/Cancel', 'take/Cancel', 'take/Reserve', 'master/AdminNews', 'member/Point'));

		$this->getCommon();

		$this->TakeCancel->copy($this->uid);

		//消す前に情報の取得を行っておく
		$this->TakeReserve->target = '*,take_reserve.*,member_base.email,member_base.memberNameSecound,member_base.memberNameFirst';
		$this->TakeReserve->joinTakeBase();
		$this->TakeReserve->joinMemberBase();
		$this->TakeReserve->arrayData = $this->TakeReserve->getDataUID($this->uid)->getData();



		if (!$this->MemberCancel->setCancel($this->uid, $this->arrayUser['id'])){
			$this->setShow('cancelError');
		}

		$arrayPoint['id'] = $this->TakeReserve->arrayData['member_base_id'];
		$arrayPoint['countReturn'] = 1;

		$this->MemberPoint->addPoint($arrayPoint);


		//メールなどの送付
		$this->MasterAdminNews->sendMailCancel($this->arrayUser, $this->TakeReserve->arrayData);

		//体験レッススンの分のキャンセルの場合
		/*if ($this->TakeReserve->arrayData['isTrial'] == 1){
			$this->MemberCancel->setSession('traialCancel', $this->TakeReserve->arrayData['id']);

			$this->setRedirect('mypage/return/step1/?type=2');
		}*/

?>