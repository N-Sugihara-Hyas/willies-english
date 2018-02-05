<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';

		if (!empty($this->arrayAll['model'])){		
			$this->addModel(array($this->arrayAll['model'], $this->arrayAll['model'] . 'Card'));
		
			$modelName = ucwords(str_replace('/', '', $this->arrayAll['model']));
			$modelNameCard = ucwords(str_replace('/', '', $this->arrayAll['model'] . 'Card'));
			$arrayDir = explode('/', $this->arrayAll['model']);
			$dirID = $arrayDir[1];
			$typeID = strtolower($dirID);
		}else{
			$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName']));	
			$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];
			$validateName = 'Validate' . ucwords($arraySetting['base']['validateDir']) . $arraySetting['base']['validateName'];				
		}
		
		//共通処理
		$this->getCommon();

		$this->$modelName->addModelTool('Form');
		
		if (!empty($this->arrayAll['model'])){
			$this->$modelName->setColum('teaching/HormworkTest');
		}else{
			$this->$modelName->setColum();			
		}



		$this->$modelName->formUpload($this->arrayPost['arrayInput'][$modelName]);

		$this->set('mode', getVar($this->arrayAll, 'mode'));
		$this->set('model', getVar($this->arrayAll, 'model'));
		$this->set('e', getVar($this->arrayAll, 'e'));
		$this->set('modelName', $modelName);
		$this->set('arraySettingAdmin', $arraySetting['base']);
		$this->set('uid', $this->$modelName->getUID());
		$this->set('arrayInput', 	$this->$modelName->arrayInput);

		
		$this->$modelName->getEditConfirmation($this->$modelName->arrayInput);

		$this->set('arrayColum', $this->$modelName->arrayColum);


?>