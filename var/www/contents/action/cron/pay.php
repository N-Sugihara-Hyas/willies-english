<?php

	/*
	*	支払状況のチェック
	*/
	$this->addModel(array('member/Base', 'take/Reserve'));
	$this->addLiblary(array('tool/Paypal'));


		$Paypal = new Paypal('company_api1.williesenglish.com', 'GGRWEV4GDSQDD6AF', 'AFcWxV21C7fd0v3bYYYRCpSSRl31A-GB0mxAuBdIvGs-6H9xLMOFYpe7');

		//退会対象者
		$this->MemberBase->addQuery('orderID1 IS NOT NULL');
		$this->MemberBase->addQuery('dateUnRegist', date('Y-m-d'));
		$this->MemberBase->addQuery('state', 3);
		$dbGet = $this->MemberBase->getData();


		//退会日の人は退会処理する
		while($item = $dbGet->getData()){
			$arrayData = $item;

			$this->MemberBase->setDropOut($arrayData);
		}


		//ポイント0にする398


		$y = date('Y');		
		$m = date('m');
		$m--;
		
		if ($m <= 0){
			$m = 12;
			$y--;
		}
		
		$date = $y . '-' . $m . '-' .date('d');
		
		$this->MemberBase->addQuery('dateUnRegist IS NOT NULL');		
		$this->MemberBase->addQuery('dateUnRegist <=', $date);
		$this->MemberBase->addQuery('countReturn >', 0);
		//$this->MemberBase->addQuery('state', 3);
		$dbGet = $this->MemberBase->getData();
		echo $this->MemberBase->log();
		
		
		while($item = $dbGet->getData()){
			$arrayData = $item;
			$arrayData['countReturn'] = 0;
			$this->MemberBase->commit($arrayData);
		}
		
		
		//キャンセルした状態の人に、退会日を入れる
		$this->MemberBase->addQuery('orderID1 IS NOT NULL');
		$this->MemberBase->addQuery('state', 3);
		$dbGet = $this->MemberBase->getData();

		while($item = $dbGet->getData()){
			$arrayData = array();
			$res = $Paypal->check_status($item['orderID1']);


			$isPay = false;

			$result = '';
			
			switch($res["STATUS"]){
				case "Active":$result = "正常支払いの状態です。";$isPay = true;break;
				case "Pending":$result = "未決済の状態です。";break;
				case "Cancelled":$result = "キャンセル済みの状態です。";break;
				case "Suspended":$result = " 一時停止の状態です。";break;
				case "Expired":$result = "請求サイクルが終了した状態です。";break;

			}


			if ($res["STATUS"] != 'Active'){
				//正常支払い以外
				if (($res["STATUS"] == 'Cancelled') || ($res['STATUS'] == 'Expired')){
					$arrayData = $item;

					

					$this->addLiblary('inoutput/Date');
					$InoutputDate = new InoutputDate();
					
					list($y, $m, $d) = explode('-', $arrayData['datePay']);

					if ($d > date('d')){
						list($y, $m) = explode('-', date('Y-m'));
					}else{
						list($y, $m) = explode('-', $InoutputDate->getDateNext(date('Y-m-d'), 'm', 1));
					}
					
					//echo $d . '/';
					
					$dayLast = $InoutputDate->getArrayMonthLast($y, $m);
					if ($d > $dayLast){
						$d = $dayLast;
					}


					if ($arrayData['cource_schedule_id']){
						$this->TakeReserve->addQuery('concat(date," ",timeStart) >=', date($y . '-' . $m . '-' . $d . ' 00:00:00'));
						$this->TakeReserve->addQuery('member_base_id', $arrayData['id']);
						$this->TakeReserve->addQuery('type <', 2);
						$this->TakeReserve->delData();
					}


					$arrayData['dateUnRegist'] = $y . '-' . $m . '-' . $d;
					$this->MemberBase->addQuery('id', $arrayData['id']);
					$this->MemberBase->setData($arrayData);
				}else{
					if (!$isPay){
						$arrayData['id'] = $item['id'];
						$arrayData['isPayAuto'] = 0;
						$this->MemberBase->commit($arrayData);
					}
				}

			}else{
				//正常支払いの場合
				$arrayData['id'] = $item['id'];
				$arrayData['dateUnRegist'] = '';
				$this->MemberBase->commit($arrayData);
			}

			echo $result . '/' . $item['id'] . '/' . $res["STATUS"] . '<br />';


	}

	exit();
		
?>