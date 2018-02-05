<?php

/***********************************************************
*	項目の削除
*/

	//共通処理
	$this->getCommon();

	//モデル情報の読み込み
	$this->addModel(array('take/Reserve', 'take/Cancel', 'member/Cancel', 'member/Base', 'master/AdminNews', 'take/Base', 'member/Point'));

	$arrayReserve = $this->TakeReserve->getDataUID($this->uid)->getData();
	

	$arrayUser = $this->MemberBase->getDataUID($arrayReserve['member_base_id'])->getData();
	

	$arrayUser['countReturn']+= $this->arrayAll['point'];
	$this->MemberBase->commit($arrayUser);
	$this->TakeCancel->copy($this->uid);

	$this->TakeReserve->addQuery('id', $this->uid);
	$this->TakeReserve->delData();
		
	$arrayPoint = $arrayUser;
	$arrayPoint['countReturn'] = 1;

	
	//講師にもお知らせ追加
	if ($this->arrayAll['point']){
		$this->MemberPoint->addPoint($arrayPoint);
	
	
		$this->MasterAdminNews->addModelTool('Mail');
		$arrayTakeBase = $this->TakeBase->getDataUID($arrayReserve['take_base_id'])->getData();
		$this->MasterAdminNews->arrayData['domain'] = $this->arraySetting['domain'];
		$this->MasterAdminNews->mailSend(23, array($arrayTakeBase['email']));

		$this->MasterAdminNews->addMailData(23, $this->MasterAdminNews->arrayMailSetting['body'], $this->MasterAdminNews->arrayMailSetting, $arrayTakeBase['id']);
	}
	

	if ($this->arrayAll['data1'] == 1){
		$this->setRedirect('admin/sch/holiday/?tID=' . $arrayReserve['take_base_id'] . '&date=' . $arrayReserve['date'] . '&time=' . $arrayReserve['timeStart'] . '&timeEnd=' . $arrayReserve['timeEnd'] . '&redirect=' . $this->arrayAll['redirect']);
	}else{
		$this->setRedirect(urldecode($this->arrayAll['redirect']));
	}

?>