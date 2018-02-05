<?php

	addModel('Model');

	/*
	*	ユーザーの設定のクラス
	*/
	class MemberSetting extends Model{

		/*
		*	設定画面で、そのステップに来られるか？来られるならば設定データの取得
		*/
		function getSettingStep($step, $arrayAll){

			if ($step >= 1){
				if (!empty($arrayAll['cource_base_id'])){
					$arrayData['cID'] = $arrayAll['cource_base_id'];
					$this->setSession('courceBase', $arrayData['cID']);
				}else{
					$arrayData['cID'] = $this->getSession('courceBase');
				}
					
				if (!$arrayData['cID']){	
					return false;
				}
			}

			if ($step >= 2){
				if (!empty($arrayAll['cource_style_id'])){
					$arrayData['csID'] = $arrayAll['cource_style_id'];
					$this->setSession('courceStyle', $arrayData['csID']);
				}else{
					$arrayData['csID'] = $this->getSession('courceStyle');
				}

				if (empty($arrayData['csID'])){
					return false;
				}
			}


			if ($step >= 3){
				if ((!empty($arrayAll['cource_schedule_id'])) && (!empty($arrayAll['dateFirst']))){
					$arrayData['cshID'] = $arrayAll['cource_schedule_id'];
					$arrayData['dateFirst'] = $arrayAll['dateFirst'];

					$this->setSession('courceSchedule', $arrayData);
				}else{
					$arrayDataSchedule = $this->getSession('courceSchedule');

					$arrayData['cshID'] = $arrayDataSchedule['cshID'];
					$arrayData['dateFirst'] = $arrayDataSchedule['dateFirst'];

				}

				if (empty($arrayData['cshID'])){
					return false;
				}
			}



			if ($step >= 4){
				if (!empty($arrayAll['time']) ){
					$arrayData['time'] = $arrayAll['time'];

					$this->setSession('courceTake', $arrayData);
				}else{
					$arrayDataSchedule = $this->getSession('courceTake');
					$arrayData = array_merge($arrayData, $arrayDataSchedule);
				}

				if (empty($arrayData['time'])){
					return false;
				}
			}

			if ($step >= 5){
				if (!empty($arrayAll['tID']) ){
					$arrayDataSchedule = $this->getSession('courceTake');
					$arrayData = array_merge($arrayData, $arrayDataSchedule);

					$arrayData['tID'] = $arrayAll['tID'];

					$this->setSession('courceTake', $arrayData);
				}else{
					$arrayDataSchedule = $this->getSession('courceTake');
					$arrayData = array_merge($arrayData, $arrayDataSchedule);
				}
			}
			if ($step >= 6){
				//子供コースの場合の処理
				if (($arrayData['cID'] == 1) && (!$this->arrayUser['isSetting'])){
					if (isset($arrayAll['levelChild']) ){
						$this->setSession('levelChild', $arrayAll['levelChild']);
					}
					$arrayData['levelChild'] = $this->getSession('levelChild');


					if (!strlen($arrayData['levelChild'])){
						return false;
					}
				}
			}

			return $arrayData;
		}

		/*
		*	設定画面で、そのステップに来られるか？来られるならば設定データの取得
		*/
		function getSettingStep2($step, $arrayAll){
			if ($step >= 1){
				if (isset($arrayAll['time'])){
					$arrayData['time'] = $arrayAll['time'];
					$arrayData['date'] = $arrayAll['date'];

					$this->setSession('schedule', $arrayData);
				}else{
					$arrayData = $this->getSession('schedule');
				}

				if (empty($arrayData['time'])){return false;}


			}

			if ($step >= 2){
				if (isset($arrayAll['tID'])){
					$arrayData['tID'] = $arrayAll['tID'];

					$this->setSession('takeTarget', $arrayData['tID']);
				}else{
					$arrayData['tID'] = $this->getSession('takeTarget');
				}

				if (empty($arrayData['tID'])){return false;}
			}

			return $arrayData;
		}

		function clear(){
			$this->setSession('courceBase', array());
			$this->setSession('courceStyle', array());
			$this->setSession('courceSchedule', array());
			$this->setSession('courceTake', array());

		}



	}



?>