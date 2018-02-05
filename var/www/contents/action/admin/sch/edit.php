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
		$this->$modelName->arrayAll = $this->arrayAll;
		
		if ($this->uid != 'reInput'){
			if (getVar($this->arrayAll, 'time')){
				$this->$modelName->arrayColum['take_base_id']['default'] = getVar($this->arrayAll, 'tID');
				$this->$modelName->arrayColum['date']['default'] = getVar($this->arrayAll, 'date');
				$this->$modelName->arrayColum['isTrial']['default'] = getVar($this->arrayAll, 'trial');
				$this->$modelName->arrayColum['timeStart']['default'] = substr(getVar($this->arrayAll, 'time'), 0, strlen(getVar($this->arrayAll, 'time')) - 3);
			}
		}
		
		$this->$modelName->target = '*,take_reserve.id as trid';
		$mode = $this->$modelName->getEdit($this->uid);

		if ($this->uid != 'reInput'){
			$this->$modelName->arrayInput['isTrial'] = getVar($this->arrayAll, 'trial');
		}

		if (isset($this->arrayAll['redirect'])){
			$this->$modelName->setSession('redirect', $this->arrayAll['redirect']);
		}else{
			$this->$modelName->setSession('redirect', 'admin/sch/list/');
		}

		$this->set('uid', $this->$modelName->getUID());
		$this->set('e', getVar($this->arrayAll, 'e'));
		$this->set('arrayColum', $this->$modelName->arrayColum);
		$this->set('reflash', getVar($this->arrayAll, 'reflash'));
		$this->set('modelName', $modelName);
		$this->set('arrayInput', $this->$modelName->arrayInput);
		$this->set('arraySettingAdmin', $arraySetting['base']);

?>