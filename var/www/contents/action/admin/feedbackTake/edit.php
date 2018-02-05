<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName']));

		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];

		//共通処理
		$this->getCommon();

		$this->$modelName->addModelTool('Form');
		$this->$modelName->setColum();
		$this->$modelName->setFormAdmin();

		$mode = $this->$modelName->getEdit($this->uid);

		//閲覧したら閲覧済みにする
		$this->$modelName->setDataUID($this->uid, array('isOpen' => 1));
		
		//FeedBackの未読の取得
		$this->TakeFeedback->addQuery('isOpen', 0);
		$this->set('countFeedback', $this->TakeFeedback->getData()->getCount());

		$this->set('uid', $this->$modelName->getUID());
		$this->set('e', getVar($this->arrayAll, 'e'));
		$this->set('arrayColum', $this->$modelName->arrayColum);
		$this->set('reflash', getVar($this->arrayAll, 'reflash'));
		$this->set('modelName', $modelName);
		$this->set('arrayInput', $this->$modelName->arrayInput);
		$this->set('arraySettingAdmin', $arraySetting['base']);

?>