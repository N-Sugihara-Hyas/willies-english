<?php

	addModel('ModelDB');

	/*
	*	会員のクラス
	*/
	class MemberBase extends ModelDB{
	var $tableName = 'member_base';
	var $tableNameSession = 'member_session';
	var $loginID = 'member_base_id';
	var $dateLastLogin = 'dateLastLogin';

		function joinTakeBase(){
			$this->addJoins(
				array('model' => 'take/Base')
			);
		}
		function joinCourceBase(){
			$this->addJoins(
				array('model' => 'cource/Base')
			);
		}
		function joinCourceStyle(){
			$this->addJoins(
				array('model' => 'cource/Style')
			);
		}
		function joinTakeReserve(){
			$this->addJoins(
				array('model' => 'take/Reserve', 'on' => 'member_base.id=take_reserve.member_base_id')
			);
		}

		/*
		*	初期設定の設定完了
		*	@params $id メンバーのID $arrayData 設定データ
		*/
		function setDataSetting($id, $arrayData){
			$arrayDataResult = $arrayData;
			$arrayDataResult['id'] = $id;
			$arrayDataResult['isSetting'] = 1;

			if (isset($arrayDataResult['time'])){
				$arrayDataResult['timeStart'] = getVar($arrayDataResult, 'time');
				$arrayDataResult['timeEnd'] = date('H:i:s', strtotime($arrayDataResult['time']) + ($arrayDataResult['weekTime'] * 60));
				unset($arrayDataResult['time']);
			}
			unset($arrayDataResult['weekTime']);

			$this->commit($arrayDataResult);
			
			
			//ステータス変更時の処理
			$this->setStatus($arrayDataResult);
		}


		/*
		*	SIDから会員情報の取得
		*	@params $sid 認証するSID
		*/
		function getDataSID($sid){
			if (!$sid){return false;}


			$this->addQuery('sid', $sid);
			return $this->getData()->getData();
		}

		/*
		*	会員をログイン可能に
		*	@params $sid 可能にするSID $pass パスワード
		*/
		function setDataSID($sid){
			if (!$arrayData = $this->getDataSID($sid) ){
				return false;
			}



			$arrayData['isLogin'] = 1;
			$arrayData['sid'] = '';


			$this->commit($arrayData);

			return true;
		}

		/*
		*	パスワード取得
		*/
		function getPassword($pass){
			$this->addLiblary('securty/Code');

			$SecurtyCode = new SecurtyCode($this->arraySetting['secretKey']);
			$pass = $SecurtyCode->getEncode($pass);

			return $pass;
		}

		/*
		*	レギュラーコースが変更可能か？
		*/
		function isChange($arrayUser){
			if ($arrayUser['dateChange'] != date('Ym')){
				return true;
			}

			return false;
		}

		/*
		*	講師情報から担当生徒の取得
		*	@params $tID 講師のID
		*	@return データベースの情報
		*/
		function getDataTake($tID){
			$this->addQuery('take_base_id', $tID);

			return $this->getData();
		}
		
		/*
		*	支払い完了
		*	@params $id ユーザーのID $type 支払いの種類
		*/
		function setPay($id, $type){
			$arrayData['id'] = $id;
			if ($type == 2){
				$arrayData['isPayDaily'] = 1;
				$arrayData['stateDaily'] = 3;
				$arrayData['isPayAuto'] = 1;
				$this->setStatusDaily($arrayData);
			}else{
				$arrayData['isPay'] = 1;
				$arrayData['isPayAuto'] = 1;
				$arrayData['state'] = 3;
				$arrayData['datePay'] = date('Y-m-d');

				$this->setStatus($arrayData);
			}
		}
		
		/*
		*	ステータス変更
		*	@params $arrayUser ユーザー情報
		*/
		function setStatus($arrayUser){
			if (isset($arrayUser['state'])){
				//支払い済み常態か否か
				if ($arrayUser['state'] == 3){
					$arrayUser['isPay'] = 1;
				}else{
					$arrayUser['isPay'] = 0;
				}

				//登録だけ状態か否か
				if ($arrayUser['state'] == 0){
					$arrayUser['isSetting'] = 0;
				}else{
					$arrayUser['isSetting'] = 1;
				}
							
				$this->commit($arrayUser);
			}
			
			return $arrayUser;
			
		}

		/*
		*	ステータス変更(グループレッスン)
		*	@params $arrayUser ユーザー情報
		*/
		function setStatusDaily($arrayUser){
			if (isset($arrayUser['stateDaily'])){
				//支払い済み常態か否か
				if ($arrayUser['stateDaily'] == 3){
					$arrayUser['isPayDaily'] = 1;
				
				}else{
					$arrayUser['isPayDaily'] = 0;
				}
				
				$this->commit($arrayUser);
			}
			
			return $arrayUser;
			
		}
		
		
		/*
		*	体験終了状態の人間の検出
		*/
		function getTrioutEnd(){
			$this->addQuery('state', 1);
			$this->addQuery('dateTest <', date('Y-m-d H:i:s'));
			
			return $this->getData();
		}
		/*
		*	体験終了状態の人間の検出(グループ)
		*/
		function getTrioutEndDaily(){
			$this->addQuery('stateDaily', 1);
			$this->addQuery('dateTestDaily <', date('Y-m-d H:i:s'));
			
			return $this->getData();
		}

		/*
		*	ドロップアウトの処理
		*	@params $arrayUser ユーザー情報
		*/
		function setDropOut($arrayUser){
			$arrayUser['state'] = 10;
			$this->setStatus($arrayUser);

			$this->addQuery('id', $arrayUser['id']);
			/*$arraySet['cource_base_id'] = 0;
			$arraySet['cource_style_id'] = 0;*/
			$arrayUser['cource_schedule_id'] = 0;
			$arrayUser['take_base_id'] = 0;
			//$arrayUser['dateChange'] = '';

			$this->setData($arrayUser);

		}
	}
	
?>