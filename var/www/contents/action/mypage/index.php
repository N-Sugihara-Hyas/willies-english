<?php
/*
*	ログイン画面
*/

		//モデル情報の読み込み
		$this->addModel(array('master/Communication', 'member/Base', 'take/Reserve', 'master/News', 'master/Communication', 'admin/Page', 'ext/Homework', 'ext/Bbs', 'member/Setting', 'group/ReserveDetails'));

		$this->getCommon();

		
		$this->MemberSetting->setSession('trialout', '');

		$this->set('arrayNews', $this->MasterNews->getData()->getDataAll());		

		$this->set('arrayCommunication', $this->MasterCommunication->getDataMixMy($this->arrayUser['id'])->getDataAll());

		$this->set('arrayDown', $this->AdminPage->getDataUID(1)->getData());
		
		$this->set('arraySchedule', $this->TakeReserve->getScheduleMy($this->arrayUser['id']));

		$this->TakeReserve->addQuery('isTrial', 1);
		$this->set('arrayScheduleTrial', $this->TakeReserve->getScheduleMy($this->arrayUser['id'], true));

		$this->set('arrayType', $this->TakeReserve->arrayType);
		$this->set('arrayWeek', array('日', '月', '火', '水', '木', '金', '土'));
		$this->set('arrayPoint', $this->TakeReserve->getFunctionData('PointHistory'));

		$this->ExtHomework->addQuery('member_base_id', $this->arrayUser['id']);
		$this->set('arrayHomework', $this->ExtHomework->getData()->getDataAll());
		
		$this->GroupReserveDetails->joinGroupReserve();
		$this->set('arrayGroup', $this->GroupReserveDetails->getScheduleMy($this->arrayUser['id']));
		

		
		//レコード取得
		$arrayRecourd = $this->MasterCommunication->getDataRecord($this->arrayUser['id']);
		$this->set('arrayRecourd', $arrayRecourd);
		
		
		$arrayTake = $this->TakeBase->getDataUID($tfb)->getData();
		$this->set('arrayTake', $arrayTake);

		//学習履歴
		$page = getVar($this->arrayAll, 'page');
				
		$this->TakeReserve->joinTakeBase();
		$this->TakeReserve->order = 'date DESC';
		$this->TakeReserve->limit = 20;		
		$this->TakeReserve->addQuery('take_reserve.date <=', date('Y-m-d'));
		$this->TakeReserve->addQuery('take_reserve.timeStart <=', date('H:i'));
		$this->TakeReserve->addQuery('take_reserve.member_base_id', $this->arrayUser['id']);
		$dbGet = $this->TakeReserve->getData();
		
		$arrayList = array();
		while ($item = $dbGet->getData()){
			$item['objHomework'] = $this->ExtHomework->getTarget($item)->getData();
			$item['objCard'] = $this->CardBase->getTarget($item)->getData();
						
			array_push($arrayList, $item);
		}		
		
		$this->set('arrayHistory', $arrayList);
		
		
		//コミュニケーション関連
		$page = getVar($this->arrayAll, 'page');
		$this->ExtBbs->addModelTool('Page');
		
		if (getVar($this->arrayAll, 'nickname')){
			$this->ExtBbs->joinTakeBase();
			$this->ExtBbs->addQuery('take_base.nickname', getVar($this->arrayAll, 'nickname'));
		}
		
		$arrayPage = $this->ExtBbs->pageGetData($this->ExtBbs->getData(), $page, 50);
		$arrayPage['arrayList'] = $this->ExtBbs->getFull($arrayPage['dbGet'], $this->arrayUser['id'], 0);

		$this->set('nickname', getVar($this->arrayAll, 'nickname'));
		$this->set('cname', getVar($this->arrayAll, 'cname'));

		$this->set('page', $page);				
		$this->set('arrayData', $arrayPage);		
		$this->set('errorBbs', getVar($this->arrayAll, 'errorBbs'));
		$this->set('errorBbsComment', getVar($this->arrayAll, 'errorBbsComment'));

		$this->set('reflashBbs', getVar($this->arrayAll, 'reflashBbs'));
?>