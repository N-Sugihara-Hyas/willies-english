<?php
/*
*	オリジナルカード画面
*/
		//モデル情報の読み込み
		$this->addModel(array('test/Base', 'test/Type', 'test/History'));

		$this->getCommon();

		$tid = getVar($this->arrayAll, 'tid');
		$this->set('tid', $tid);
		$this->set('arrayType', $this->TestType->getCourceBase($this->arrayUser['cource_base_id'])->getDataAll());

		$this->set('arrayHitType', $this->TestType->getDataUID(getVar($this->arrayAll, 'tid'))->getData());
		$this->set('arrayTest', $this->TestBase->getType(getVar($this->arrayAll, 'tid'))->getDataAll());

		$this->TestHistory->joinTestBase();
		if ($tid){$this->TestHistory->addQuery('test_base_id', $tid);}
		$this->TestHistory->addQuery('member_base_id', $this->arrayUser['id']);
		$this->set('arrayHistory', $this->TestHistory->getData()->getDataAll());
?>