<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		
		if (!empty($this->arrayAll['model'])){			
			$this->addModel(array($this->arrayAll['model'], $this->arrayAll['model'] . 'Card'));
			$modelName = ucwords(str_replace('/', '', $this->arrayAll['model']));
		}else{
			$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName'], 'take/Reserve', 'member/Base', 'member/Point', 'member/BaseLog'));
			$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];			
		}
		

		//共通処理
		$this->getCommon();

		$this->$modelName->addModelTool('Form');

		if (!empty($this->arrayAll['model'])){	
			$this->$modelName->setColum('teaching/HormworkTest');
		}else{
			$this->$modelName->setColum();			
		}
		
		$uid = $this->$modelName->getEditEnd();
		
		
		

		$this->setRedirect($this->arrayAction['dir'] . 'list/' . $uid . '/?e=reflash');
?>