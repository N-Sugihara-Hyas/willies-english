<?php
/*
*	講師の情報詳細
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array('take/Reserve', 'member/Base', 'take/ScheduleView', 'setting/Meta', $arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName']));
		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];

		//共通処理
		$this->getCommon();

		$this->$modelName->addModelTool('Colum');
		$this->$modelName->setColum();

		$arrayInput = $this->$modelName->getDataUID($this->uid)->getData();


		//担当生徒の情報
		$arrayMemberBase = $this->MemberBase->getDataTake($this->uid)->getDataAll();


		//スケジュール
		$this->arrayAll['takeName'] = $arrayInput['nickname'];

		$arraySet = $this->TakeScheduleView->setView($this->arrayAll);
		
		//今までのレッスン数
		$lessonCount = $this->TakeReserve->getScheduleTake($this->uid, $arraySet['dateStart'], $arraySet['dateEnd'])->getCount();
		$this->$modelName->arrayInput = $arrayInput;
		$this->$modelName->updateDataOut();
		
		//講師の
		$this->set('isTake', true);

		$this->set('uid', $this->uid);
		$this->set('arrayMemberBase', $arrayMemberBase);
		$this->set('memberCount', $this->MemberBase->dbGet->getCount());
		$this->set('lessonCount', $lessonCount);
		$this->set('arrayColum', $this->$modelName->arrayColum);
		$this->set('modelName', $modelName);
		$this->set('arrayInput', $this->$modelName->arrayInput);
		$this->set('arraySettingAdmin', $arraySetting['base']);
		foreach ($arraySet as $key => $item){
			
			$this->set($key, $item);
		}


?>