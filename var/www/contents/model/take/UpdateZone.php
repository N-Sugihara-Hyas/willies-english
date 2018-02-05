<?php

	addModel('ModelDB');

	/*
	*	講師のスケジュールの空いているのチェック(Updateのためのテーブル)
	*/
	class TakeUpdateZone extends ModelDB{
	var $tableName = 'take_update_zone';
	var $order = 'time ASC';
	var $group = '*';

		/*
		 *	講師スタンバイ状態の予約データの取得
		 *@params $tID 講師を限定する場合
		 *@return スタンバイ状態のデータ
		*/
		function getStandby($tID, $timeAdd=40){
			$time = date('H:i:s');
			$week = date('w');
			$date = date('Y-m-d');

			//現時刻が23時30以上の場合は翌日を見る
			if (date('H') == 23){
				if (date('i') > 30){
					$week++;
					$date = date('Y-m-d', time() + (3600 * 24));
				}
			}

			$this->dateNow = $date;

			//一番近日のスケジュールの取得
			$this->addQuery('time >=', $time);
			$this->addQuery('week', $week);

			if ($tID){
				$this->addQuery('take_base_id', $tID);
			}

			$arrayData = $this->getData()->getData();

			//現時刻との剥離を調べる
			$timeNow = time();
			$timeTarget = strtotime($arrayData['time']);
			$timeMin = ($timeTarget - $timeNow) / 60;

			if ($timeMin > $timeAdd){
				return false;
			}

			//既に登録済みの場合
			$TakeUpdate = $this->getModel('take/Update');
			$TakeUpdate->addQuery('dateTime', $date . ' ' . $arrayData['time']);
			$TakeUpdate->addQuery('take_base_id', $tID);
			$arrayTakeUpdate = $TakeUpdate->getData()->getData();

			if ($arrayTakeUpdate){return false;}

			return $arrayData;
		}

		/*
		 *	講師スタンバイオーバー状態の予約データの取得
		 *@params $tID 講師
		 *@return オーバー状態のデータ
		*/
		function getOver($tID){
			$timeNow = date('H:i:s');
			$week = date('w');
			$date = date('Y-m-d');

			//一番近いものを検索
			$this->order = 'time DESC';
			$this->addQuery('take_base_id', $tID);
			$this->addQuery('time <', $timeNow);
			$this->addQuery('week', $week);
			$arrayData = $this->getData()->getData();

			if ($arrayData){
				//ちゃんとスタンバってるか確認
				$TakeUpdate = $this->getModel('take/Update');

				$TakeUpdate->addQuery('take_base_id', $tID);
				$TakeUpdate->addQuery('dateTime', $date . ' ' . $arrayData['time']);
				$arrayUpdate = $TakeUpdate->getData()->getData();

				if (!$arrayUpdate){
					//スタンバっていないため、アウト
					$arrayTake['dateTime'] = $date . ' ' . $arrayData['time'];
					$arrayTake['take_base_id'] = $tID;
					$arrayTake['isOK'] = -2;

					$TakeUpdate->commit($arrayTake);
				}
			}
		}
	}
?>