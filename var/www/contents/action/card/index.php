<?php
/*
*	単語帳トップ画面
*/

		//モデル情報の読み込み
		$this->addModel(array('master/NewsCard'));

		$this->getCommon('', true);

		$this->MasterNewsCard->order = 'master_news_card.id DESC';
		$this->set('arrayNew', $this->MasterNewsCard->getMyCard($this->arrayUser['id'])->getDataAll());
?>