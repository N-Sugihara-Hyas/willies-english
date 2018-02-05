<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName'], 'member/Base'));

		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];

		//共通処理
		$this->getCommon();


		$this->$modelName->addModelTool('Form');
		
		//編集種類の保存と判定
		if (!empty($this->arrayAll['type'])){
			$this->$modelName->setSession('type', $this->arrayAll['type']);
		}
		$type = $this->$modelName->getSession('type');
		
		if (($type == 1) || ($type == 2) ){
			$this->$modelName->setColum('card/Base');		
		}else{
			$this->$modelName->arrayColum['modified']['default'] = date('Y-m-d');
			$this->$modelName->setColum();
		}
		
		if (getVar($this->arrayAll, 'new')){
			$this->$modelName->clearCard();
		}

		$mode = $this->$modelName->getEdit($this->uid);

		//編集モード
		if ($this->$modelName->getUID()){
			if (getVar($this->arrayAll, 'new')){
				$arrayData = $this->$modelName->loadCard(0, $this->$modelName->getUID(), 3);
				$this->$modelName->setPage(0);

				$this->$modelName->arrayInput['card_base_id'] = $this->$modelName->getUID();
			}
		}

		$arrayCardDetails = $this->$modelName->getCard();

		$this->$modelName->arrayInput['body1'] = getVar($arrayCardDetails, 'body1');
		$this->$modelName->arrayInput['body2'] = getVar($arrayCardDetails, 'body2');


		$this->set('uid', $this->$modelName->getUID());
		$this->set('e', getVar($this->arrayAll, 'e'));
		$this->set('arrayColum', $this->$modelName->arrayColum);
		$this->set('reflash', getVar($this->arrayAll, 'reflash'));
		$this->set('modelName', $modelName);
		$this->set('arrayInput', $this->$modelName->arrayInput);
		$this->set('arraySettingAdmin', $arraySetting['base']);

?>