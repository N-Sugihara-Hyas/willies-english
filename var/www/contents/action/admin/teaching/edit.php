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
		}
		
		//共通処理
		$this->getCommon();
		
		//カードの更新がある場合
		if (!empty($this->arrayPost['arrayInput'])){
			foreach ($this->arrayPost['arrayInput'] as $key => $objInput){
				$objCommit['id'] = $key;
				$objCommit['body1'] = $objInput['body1'];
				$objCommit['body2'] = $objInput['body2'];
				
				$this->$modelNameCard->commit($objCommit);
			}
		}
		
		
		$this->$modelName->addModelTool('Form');

		if (!empty($this->arrayAll['model'])){	
			$this->$modelName->setColum('teaching/HormworkTest');
		}else{
			$this->$modelName->setColum();
		}
		
		$mode = $this->$modelName->getEdit($this->uid);

		if (!empty($this->arrayAll['model'])){	
			$this->$modelNameCard->addQuery('teaching_' . $typeID . '_id', $this->$modelName->getUID());
			$arrayCard = $this->$modelNameCard->getData()->getDataAll();
			$this->set('arrayCard', $arrayCard);
		}
		
		$this->set('dirID', $dirID);
		$this->set('uid', $this->$modelName->getUID());
		$this->set('e', getVar($this->arrayAll, 'e'));
		$this->set('mode', getVar($this->arrayAll, 'mode'));
		$this->set('model', getVar($this->arrayAll, 'model'));
		$this->set('arrayColum', $this->$modelName->arrayColum);
		$this->set('reflash', getVar($this->arrayAll, 'reflash'));
		$this->set('modelName', $modelName);
		$this->set('arrayInput', $this->$modelName->arrayInput);
		$this->set('arraySettingAdmin', $arraySetting['base']);

		if (getVar($this->arrayAll, 'mode') == 'view'){
			$this->setShow('editConfirmation');
		}
?>