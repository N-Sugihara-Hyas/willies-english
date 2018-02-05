<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName']));

		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];
		
		$this->getCommon();

		$this->$modelName->addModelTool('Form');
		$this->$modelName->setColum();
		$this->$modelName->uid = $this->arrayUser['id'];
		$this->$modelName->type = 2;


		$mode = $this->$modelName->getEdit($this->uid);

		if (getVar($this->arrayAll, 'new')){
			$this->$modelName->clearCard();
		}

		//編集モード
		if ($this->$modelName->getUID()){
			if (getVar($this->arrayAll, 'new')){
				$arrayData = $this->$modelName->loadCard($this->arrayUser['id'], $this->$modelName->getUID());
				$this->$modelName->setPage(0);
			}
		}


		if (($this->uid != 'reInput') && ($this->uid != 'error')){
			$this->$modelName->arrayInput['card_base_id'] = $this->uid;
		}

		$arrayCardDetails = $this->$modelName->getCard();

		$this->$modelName->arrayInput['body1'] = getVar($arrayCardDetails, 'body1');
		$this->$modelName->arrayInput['body2'] = getVar($arrayCardDetails, 'body2');


		$this->set('page', $this->$modelName->getPage());
		$this->set('uid', $this->$modelName->getUID());
		$this->set('e', getVar($this->arrayAll, 'e'));
		$this->set('arrayColum', $this->$modelName->arrayColum);
		$this->set('reflash', getVar($this->arrayAll, 'reflash'));
		$this->set('modelName', $modelName);
		$this->set('arrayInput', $this->$modelName->arrayInput);
		$this->set('arraySettingAdmin', $arraySetting['base']);

?>