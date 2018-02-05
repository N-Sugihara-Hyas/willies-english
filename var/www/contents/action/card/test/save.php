<?php
/*
*	オリジナルカード画面
*/
		//モデル情報の読み込み
		$this->addModel(array('test/Details', 'test/History'));

		$this->getCommon();

		$tid = $this->arrayAll['tid'];
		$did = $this->arrayAll['did'];

		$arrayAnser = $this->TestDetails->getAnser();

		$this->TestHistory->addQuery('member_base_id', $this->arrayUser['id']);
		$this->TestHistory->addQuery('test_base_id', $tid);
		$arrayData = $this->TestHistory->getData()->getData();

		$arrayData['member_base_id'] = $this->arrayUser['id'];
		$arrayData['test_base_id'] = $tid;
		$arrayData['test_details_id'] = $did;
		$arrayData['anser'] = json_encode($arrayAnser);

		$this->TestHistory->commit($arrayData);

		$this->setRedirect('card/test/');


?>