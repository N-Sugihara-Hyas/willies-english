<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName'], 'ext/Homework', 'member/Base'));
		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];

		//共通処理
		$this->getCommon();

		$this->$modelName->addModelTool('Form');
		$arrayCard = $this->$modelName->getFormData();		
		$arrayCardAll = $this->$modelName->getCardAll();
				
		if ($arrayCardAll){
			$cid = $this->$modelName->createCard($arrayCard['cardName'], $this->$modelName->getSession('mID'), 1, $this->arrayUser['id'], $arrayCard);
			
			$arrayCard['member_base_id'] = $arrayHome['member_base_id'] = $this->$modelName->getSession('mID');
			$arrayCard['take_base_id'] = $this->arrayUser['id'];
			
	
			//テンプレートが1以外
			$this->$modelName->addFeedBack($arrayCard, $cid);
		}

				
		//HomeWork系の記述がある場合
		if ((!empty($arrayCard['gcc'])) || (!empty($arrayCard['rlc'])) || (!empty($arrayCard['followup']))){
			$arrayHome['date'] = $arrayCard['modified'];
			$arrayHome['gcc'] = $arrayCard['gcc'];
			$arrayHome['rlc'] = $arrayCard['rlc'];
			$arrayHome['followup'] = $arrayCard['followup'];
			$arrayCard['date'] = $arrayCard['modified'];
			$arrayCard['member_base_id'] = $arrayHome['member_base_id'] = $this->$modelName->getSession('mID');
			$arrayCard['take_base_id'] = $arrayHome['take_base_id'] = $this->arrayUser['id'];

				
			$this->ExtHomework->commit($arrayHome);
		
		}
		
		$arrayData = $this->MemberBase->getDataUID($this->$modelName->getSession('mID'))->getData();
		
		$this->$modelName->arrayData = $arrayCard;
		$this->$modelName->arrayData['homework'] = '';
		$this->$modelName->arrayData['cid'] = $cid;
		
		if (!empty($arrayHome['gcc'])){
			$this->$modelName->arrayData['homework'].= "・GCC\n" . $arrayHome['gcc'] . "\n";
		}
		if (!empty($arrayHome['rlc'])){
			$this->$modelName->arrayData['homework'].= "・RLC\n" . $arrayHome['rlc'] . "\n";
		}
		if (!empty($arrayHome['followup'])){
			$this->$modelName->arrayData['homework'].= "・followup\n" . $arrayHome['followup'] . "\n";
		}
		
		$this->$modelName->addModelTool('Mail');
		$this->$modelName->mailSend(52, array($arrayData['email']));
		
		$this->setRedirect('ext/list/?e=reflash');
?>