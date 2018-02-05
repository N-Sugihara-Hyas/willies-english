<?php
/*
*	トピックスリストの読み込み
*/
		//共通処理
		$this->getCommon();

		//モデル情報の読み込み
		$this->addModel(array('teaching/Base', 'member/Base', 'take/Feedback', 'ext/Homework', 'card/BaseTake', 'card/Details', 'take/Reserve'));
		$modelName = 'ExtHomework';

		if (isset($this->arrayAll['id'])){
			$mID = $this->arrayAll['id'];
			$this->$modelName->setSession('mID', $this->arrayAll['id']);
		}
		
		$mID = $this->$modelName->getSession('mID');

		if (!$mID){$this->setRedirect('errors');}

		$this->$modelName->addQuery('member_base_id', $mID);


		//教材の情報取得
		$arrayType = $this->TeachingBase->getFunctionData('Teaching');
		foreach ($arrayType as $key => $value){
			$arrayTextBook[$value['value']] = $this->TeachingBase->getCategory($key)->getDataAll();
		}
		
		$this->set('arrayTextBook', $arrayTextBook);
		
		//メモの保存
		if (!empty($this->arrayAll['memoHomework'])){
			$arrayDataMember['id'] = $mID;
			$arrayDataMember['memoHomework'] = $this->arrayAll['memoHomework'];
			$this->MemberBase->commit($arrayDataMember);
		}
		//教材の保存
		if (!empty($this->arrayAll['subText'])){
			$arrayDataMember['id'] = $mID;
			$arrayDataMember['subText'] = $this->arrayAll['subText'];
			$this->MemberBase->commit($arrayDataMember);
		}
		
		//フィードバック
		$this->TakeFeedback->setSession('mID', $mID);
		$this->TakeFeedback->target = '*,take_feedback.*';
		$this->TakeFeedback->joinTakeBase();
		$this->TakeFeedback->addQuery('member_base_id', $mID);
		$this->set('arrayFeedback', $this->TakeFeedback->getData());

		//宿題
		$this->ExtHomework->setSession('mID', $mID);
		$this->ExtHomework->target = '*,ext_homework.*';
		$this->ExtHomework->joinTakeBase();
		$this->ExtHomework->addQuery('member_base_id', $mID);
		$db = $this->ExtHomework->getData();
		
		$arrayHome = array();
		while ($objItem = $db->getData()){			
			$objItem = array_merge($objItem, $this->ExtHomework->getTeaching($objItem));
			array_push($arrayHome, $objItem);	

		}
		
		$this->set('arrayHomework', $arrayHome);

		//カード
		$this->CardBaseTake->setSession('mID', $mID);
		$this->CardBaseTake->target = '*,card_base.*';
		$this->CardBaseTake->joinTakeBase();
		$this->CardBaseTake->addQuery('card_base.member_base_id', $mID);
		$this->CardBaseTake->addQuery('card_base.type', 1);

		$this->set('arrayCardBase', $this->CardBaseTake->getData());
		$this->set('CardDetails', $this->CardDetails);


		//レコード
		$this->set('arrayRecord', $this->TakeReserve->getRecode($mID));

		//テンプレートで使う変数の設定
		$this->MemberBase->target = '*,member_base.*';
		$this->MemberBase->joinCourceBase();
		$this->MemberBase->joinCourceStyle();
		$this->MemberBase->joinTakeBase();
		$arayMember = $this->MemberBase->getDataUID($mID)->getData();

		$this->set('mid', $mID);
		$this->set('arrayState', $this->MemberBase->getFunctionData('MemberState'));
		$this->set('arrayMember', $arayMember);
		$this->set('searchType', $this->$modelName->searchType);
		$this->set('my', '/' . $this->arrayAction['dir'] . $this->arrayAction['a'] . '/');
		$this->set('arrayColum', $this->$modelName->arrayColum);
		$this->set('e', getVar($this->arrayAll, 'e'));
		$this->set('page', $this->$modelName->page);
		$this->set('modelName', $modelName);
		$this->set('arrayData', $arrayData);
		$this->set('arrayInput', $this->$modelName->arrayInput);

		$this->set('arraySettingAdmin', $arraySetting['base']);

?>