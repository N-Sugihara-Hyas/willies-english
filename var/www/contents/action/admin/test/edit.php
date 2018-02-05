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
		$this->$modelName->setColum();

		if (getVar($this->arrayAll, 'new')){
			$this->$modelName->clearTest();
		}

		$this->$modelName->arrayColum['modified']['default'] = date('Y-m-d');
		$mode = $this->$modelName->getEdit($this->uid);

		//編集モード
		if ($this->$modelName->getUID()){
			if (getVar($this->arrayAll, 'new')){
				$arrayData = $this->$modelName->loadTest(0, $this->$modelName->getUID());
				$this->$modelName->setPage(0);

				$this->$modelName->arrayInput['test_base_id'] = $this->$modelName->getUID();
			}
		}


		$arrayTestDetails = $this->$modelName->getTest();


		$this->$modelName->arrayInput['url'] = getVar($arrayTestDetails, 'url');
		$this->$modelName->arrayInput['body1'] = getVar($arrayTestDetails, 'body1');
		$this->$modelName->arrayInput['body2'] = getVar($arrayTestDetails, 'body2');

		for ($i = 1; $i <= 4; $i++){
			$this->$modelName->arrayInput['select' . $i] = getVar($arrayTestDetails, 'select' . $i);
		}
		$this->$modelName->arrayInput['hit'] = getVar($arrayTestDetails, 'hit');

		$this->set('page', $this->$modelName->getPage());
		$this->set('uid', $this->$modelName->getUID());
		$this->set('e', getVar($this->arrayAll, 'e'));
		$this->set('arrayColum', $this->$modelName->arrayColum);
		$this->set('reflash', getVar($this->arrayAll, 'reflash'));
		$this->set('modelName', $modelName);
		$this->set('arrayInput', $this->$modelName->arrayInput);
		$this->set('arraySettingAdmin', $arraySetting['base']);

?>