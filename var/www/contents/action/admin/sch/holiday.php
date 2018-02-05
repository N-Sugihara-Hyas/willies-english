<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';

		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName'], 'take/Base', 'master/AdminNews', 'take/Reserve', 'take/Schedule'));
		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];

		//共通処理
		$this->getCommon();

		if (!empty($this->arrayAll['isAll'])){
			//講師のスケジュール取得
			$this->TakeSchedule->addQuery('week', date('w', strtotime($this->arrayAll['date'])));
			$arrayResultTest = $this->TakeSchedule->getDataTake($this->arrayAll['tID']);

			//既に入っているスケジュール
			$arraySch = $this->TakeReserve->getScheduleTake($this->arrayAll['tID'], $this->arrayAll['date'], $this->arrayAll['date'])->getDataAll();

			foreach ($arrayResultTest as $item){
				foreach  ($item as $key => $item2){
					if ($item2){
						$arrayResult[$key] = $key;
						$arrayResult[$key] = date('H:i', strtotime($key) + 60 * 25);

						foreach ($arraySch as $item3){
							if ($key == date('H:i', strtotime($item3['timeStart'])) ){
								unset($arrayResult[$key]);
							}
						}
					}
				}
			}
		}else{
			$arrayResult[$this->arrayAll['time']] = '';
			if (isset($this->arrayAll['timeEnd'])){
				$arrayResult[$this->arrayAll['time']] = $this->arrayAll['timeEnd'];
			}
		}


		foreach ($arrayResult as $key => $item){
			$timeCount = $skypeTime = 25;
			if ($item){
				$time = strtotime($item) - strtotime($key);
				$timeCount =  $time / 60;
			}

			$timeCount = $timeCount / 25;

			for ($i = 0; $i < $timeCount; $i++){
				$key = date('H:i:s', strtotime($key) + ((60 * 25 + 60 * 5) * $i));
				
				$this->TakeReserve->addDataTime(0, $this->arrayAll['date'], $key, $skypeTime, 0, $this->arrayAll['tID'], -2, 1, true);
			}
		}

		$this->setRedirect(urldecode($this->arrayAll['redirect']));
?>