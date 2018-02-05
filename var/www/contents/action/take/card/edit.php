<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName'], 'member/Base', 'ext/Homework'));

		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];

		//共通処理
		$this->getCommon();


		$this->$modelName->addModelTool('Form');
		$this->$modelName->setColum();

		if (getVar($this->arrayAll, 'new')){
			$this->$modelName->clearCard();
		}

		$this->$modelName->arrayColum['modified']['default'] = date('Y-m-d');

		$mID = $this->$modelName->getSession('mID');					
		
		$this->MemberBase->target = '*,member_base.*';
		$this->MemberBase->joinCourceBase();


		$this->$modelName->arrayColum['cardName']['default'] = 'Lesson Review';
		$mode = $this->$modelName->getEdit($this->uid);

		//編集モード
		if ($this->$modelName->getUID()){
			if (getVar($this->arrayAll, 'new')){
				$arrayData = $this->$modelName->loadCard($mID, $this->$modelName->getUID());
				$this->$modelName->setPage(0);
				
				$this->$modelName->arrayInput['comment'] = $this->$modelName->arrayInput['free'];
			}
		}
		
		//確認画面からの編集
		if (strlen(getVar($this->arrayAll, 'cpage'))){
			$this->$modelName->setPage($this->arrayAll['cpage']);
		}		
		
		//レベル
		$arrayMember = $this->MemberBase->getDataUID($mID)->getData();
		if (getVar($this->arrayAll, 'new')){
			$this->$modelName->arrayInput['level'] = $arrayMember['level'];
		}

		
		$arrayCardDetails = $this->$modelName->getCard();


		$this->$modelName->arrayInput['body1'] = getVar($arrayCardDetails, 'body1');
		$this->$modelName->arrayInput['body2'] = getVar($arrayCardDetails, 'body2');

		$this->set('page', $this->$modelName->getPage());
		$this->set('arrayMember', $arrayMember);
		$this->set('uid', $this->$modelName->getUID());
		$this->set('e', getVar($this->arrayAll, 'e'));
		$this->set('arrayColum', $this->$modelName->arrayColum);
		$this->set('reflash', getVar($this->arrayAll, 'reflash'));
		$this->set('modelName', $modelName);
		$this->set('arrayInput', $this->$modelName->arrayInput);
		$this->set('arraySettingAdmin', $arraySetting['base']);

?>