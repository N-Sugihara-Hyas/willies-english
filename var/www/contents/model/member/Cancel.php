<?php

	addModel('ModelDB');

	/*
	*	キャンセルのクラス
	*/
	class MemberCancel extends ModelDB{
	var $tableName = 'member_cancel';
	var $countCancel = 2;		//キャンセルは月に二回まで

		/*
		*	スケジュールのキャンセル
		*	@params $rid 予約のID $uid ユーザーのID
		*	@return 予約取消できないものはfalse、できればtrue
		*/
		function setCancel($rid, $uid){
			//ユーザーの情報取得
			$MemberBase = $this->getModel('member/Base');
			$dbGetUser = $MemberBase->getDataUID($uid);
			$dbGetUser->getData();

			//予約情報の取得
			$TakeReserve = $this->getModel('take/Reserve');

			$arrayReserve = $TakeReserve->getDataUID($rid)->getData();
			
			//予約が存在しなければ、エラー
			if (!$arrayReserve){
				return false;
			}

			//本人の予約かの確認
			if ($arrayReserve['member_base_id'] != $dbGetUser->arrayData['id']){
				return false;
			}


			//今月指定回数振替を使った人間は不可
			if ($this->isCancel($uid, $arrayReserve)){
				//振替ポイントの追加
				$dbGetUser->arrayData['countReturn']++;
				$dbGetUser->commit();
			}


			//キャンセルの履歴に追加
			$this->addData(array('date' => date('Ym'), 'member_base_id' => $uid, 'cancelDate' => $arrayReserve['date'], 'cancelTime' => $arrayReserve['timeStart']));

			//予約を削除する
			$TakeReserve->addQuery('id', $rid);
			$TakeReserve->delData();

			return true;
		}

		/*
		*	キャンセルの条件をみたいしているか？
		*	@params $uid ユーザーの情報 $arrayReserve 予約情報
		*	@return 問題なければtrue、問題があればfalse
		*/
		function isCancel($uid, $arrayReserve){
			//体験はキャンセル不可
			if ($arrayReserve['isTrial']){
				//二回キャンセルしてなければ、キャンセル可能。
				$MemberCancelTrial = $this->getModel('member/CancelTrial');
				

				if ($MemberCancelTrial->isCancel($uid, $arrayReserve) ){
					return true;
				}

				return false;
			}else{
				//レギュラーレッスンの場合
				if ($arrayReserve['type'] == 1){
					//ユーザー情報の取得
					if (!isset($this->arrayMember)){
						$MemberBase = $this->getModel('member/Base');
						$this->arrayMember = $MemberBase->getDataUID($uid)->getData();
					}

					//かつ、ユーザーがまだ支払ってない場合
					if (!$this->arrayMember['isPay']){
						if (!$arrayReserve['isTrial']){
							//トライアルでなければキャンセル不可
							return false;
						}
					}
				}
			}

			//1時間前までにキャンセル申込したか？
			$timeNow = time() + (60 * 60);
			$timeReserve = strtotime($arrayReserve['date'] . ' ' . $arrayReserve['timeStart']);
						
			
			if ($timeNow > $timeReserve){
				return false;
			}
			
			
			//キャンセルを今月に２回行ったか？
			$date = date('Ym');

			$this->addQuery('date', $date);
			$this->addQuery('member_base_id', $uid);
			$count = $this->getData()->getCount();


			if ($count >= $this->countCancel){
				return false;
			}

			return true;
		}
	}
?>