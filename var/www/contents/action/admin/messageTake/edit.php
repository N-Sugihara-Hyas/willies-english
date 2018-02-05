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
		$this->$modelName->setColum('take/MessageTake');

		if ($this->uid != 'reInput'){
			if (getVar($this->arrayAll, 'res')){
				$this->$modelName->arrayColum['to_id']['default'] = $this->arrayAll['res'];
			}

			if (isset($this->arrayAll['subject'])){
				$this->$modelName->arrayColum['subject']['default'] = 'Re:' . $this->arrayAll['subject'];
			}
		}

		$mode = $this->$modelName->getEdit($this->uid);


		$this->set('uid', $this->$modelName->getUID());
		$this->set('e', getVar($this->arrayAll, 'e'));
		$this->set('arrayColum', $this->$modelName->arrayColum);
		$this->set('reflash', getVar($this->arrayAll, 'reflash'));
		$this->set('modelName', $modelName);
		$this->set('arrayInput', $this->$modelName->arrayInput);
		$this->set('arraySettingAdmin', $arraySetting['base']);

?>