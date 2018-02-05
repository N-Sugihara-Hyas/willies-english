<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName'], 'take/Reserve', 'member/Base', 'member/Point', 'member/BaseLog'));
		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];

		//共通処理
		$this->getCommon();


		$this->$modelName->addModelTool('Form');
		$this->$modelName->setColum('member/BaseAdmin');


		$uid = $this->$modelName->getEditEnd();

		$this->MemberBaseLog->addData($this->$modelName->arrayDataIti);

		$this->$modelName->arrayData['id'] = $uid;
		$this->$modelName->setStatus($this->$modelName->arrayData);
		$this->$modelName->setStatusDaily($this->$modelName->arrayData);

		if ($this->$modelName->arrayData['state'] == 10){
			if ($this->$modelName->arrayData['datePay']){
				$this->addLiblary('inoutput/Date');
				list($y, $m, $d) = explode('-', $this->$modelName->arrayData['datePay']);

				if ($d > date('d')){
					list($y, $m) = explode('-', date('Y-m'));
				}else{
					$InoutputDate = new InoutputDate();
					list($y, $m) = explode('-', $InoutputDate->getDateNext(date('Y-m-d'), 'm', 1));
				}

				$this->TakeReserve->addQuery('concat(date," ",timeStart) >=', date($y . '-' . $m . '-' . $d . ' 00:00:00'));
			}else{
				$this->TakeReserve->addQuery('concat(date," ",timeStart) >=', date('Y-m-d H:i:s'));
			}

			$this->TakeReserve->addQuery('member_base_id', $this->$modelName->arrayData['id']);
			$this->TakeReserve->delData();

			$this->MemberBase->addQuery('id', $this->$modelName->arrayData['id']);

			/*$arraySet['cource_base_id'] = 0;
			$arraySet['cource_style_id'] = 0;*/
			$arraySet['cource_schedule_id'] = 0;
			$arraySet['take_base_id'] = 0;

			$this->MemberBase->setData($arraySet);
		}

		if ($this->$modelName->arrayData['state'] == 10){
			$this->$modelName->setDropOut($this->$modelName->arrayData);
		}

		//$this->MemberPoint->addPoint($this->MemberBase->arrayData);

		$this->setRedirect($this->$modelName->getSession('returnURL') . '&e=reflash');
?>