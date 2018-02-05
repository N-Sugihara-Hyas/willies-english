<?php
/*
*	講師の情報詳細
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array('take/Reserve', 'member/Base', 'take/ScheduleView', $arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName']));
		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];

		//共通処理
		$this->getCommon();

		$this->$modelName->addModelTool('Colum');
		$this->$modelName->setColum();

		$arrayInput = $this->$modelName->getDataUID($this->uid)->getData();
		$arrayInput['pass'] = '-';


		//担当生徒の情報
		$arrayMemberBase = $this->MemberBase->getDataTake($this->uid)->getDataAll();

		//今までのレッスン数
		$lessonCount = $this->TakeReserve->getScheduleTake($this->uid, '2010-10-10', date('Y-m-d H:i:s'))->getCount();

		//スケジュール
		$this->arrayAll['takeName'] = $arrayInput['nickname'];

		$arraySet = $this->TakeScheduleView->setView($this->arrayAll);

		$this->set('isTake', true);

		$this->set('arrayMemberBase', $arrayMemberBase);
		$this->set('memberCount', $this->MemberBase->dbGet->getCount());
		$this->set('lessonCount', $lessonCount);
		$this->set('arrayColum', $this->$modelName->arrayColum);
		$this->set('modelName', $modelName);
		$this->set('arrayInput', $arrayInput);
		$this->set('arraySettingAdmin', $arraySetting['base']);
		foreach ($arraySet as $key => $item){
			$this->set($key, $item);
		}


?>