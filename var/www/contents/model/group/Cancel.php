<?php

	addModel('ModelDB');

	/*
	*	キャンセルのクラス
	*/
	class GroupCancel extends ModelDB{
	var $tableName = 'group_cancel';
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
			$GroupReserve = $this->getModel('group/ReserveDetails');

			$GroupReserve->joinGroupReserve();
			$arrayReserve = $GroupReserve->getDataUID($rid)->getData();
			
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
				$dbGetUser->arrayData['countGroup']++;
				$dbGetUser->commit();
			}

			//キャンセルの履歴に追加
			$this->addData(array(
			 'date' => date('Ym'),
			 'member_base_id' => $uid,
			 'cancelDate' => date('Y-m-d', strtotime($arrayReserve['dateStart'])),
			 'cancelTime' => date('H:i:s', strtotime($arrayReserve['dateStart']))
			));
			
			//予約を削除する
			$GroupReserve->setCancel($rid);
			exit();
			

			return true;
		}

		/*
		*	キャンセルの条件をみたいしているか？
		*	@params $uid ユーザーの情報 $arrayReserve 予約情報
		*	@return 問題なければtrue、問題があればfalse
		*/
		function isCancel($uid, $arrayReserve){
			//1時間前までにキャンセル申込したか？
			$timeNow = time() + (60 * 60);
			$timeReserve = strtotime(date('Y-m-d', $arrayReserve['dateStart']) . ' ' . date('H:i:s', $arrayReserve['dateStart']));
						
			
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