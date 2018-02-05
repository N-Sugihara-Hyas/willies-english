<?php

	addModel('ModelDB');

	/*
	*	キャンセルのクラス
	*/
	class MemberCancelTrial extends ModelDB{
	var $tableName = 'member_cancel_trial';
	var $countCancel = 2;		//体験のキャンセルは二回まで

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


			//指定回数振替を使った人間は不可
			if (!$this->isCancel($uid, $arrayReserve)){
				return false;
			}


			//キャンセルの履歴に追加
			$this->addData(array('date' => date('Ym'), 'member_base_id' => $uid, 'cancelDate' => $arrayReserve['date'], 'cancelTime' => $arrayReserve['timeStart']));

			//予約を削除する
			$TakeReserve->addQuery('id', $rid);
			$TakeReserve->delData();

			//繰り上がり処理
			$TakeReserve->order = 'date ASC';
			$TakeReserve->addQuery('member_base_id', $arrayReserve['member_base_id']);
			$TakeReserve->addQuery('date >', $arrayReserve['date']);
			$TakeReserve->addQuery('isTrial', 0);
			$arrayReserve = $TakeReserve->getData()->getData();

			$arrayReserve['isTrial'] = 1;
			$TakeReserve->commit($arrayReserve);


			return true;
		}


		function isCancel($uid, $arrayReserve){
			$this->addQuery('member_base_id', $uid);

			if ($this->getData()->getCount() >= $this->countCancel){
				return false;
			}

			$MemberBase = $this->getModel('member/Base');
			$arrayMember = $MemberBase->getDataUID($uid)->getData();
			//レギュラーも体験はキャンセル不可
			if ($arrayMember['state'] == 3){
				return false;
			}

			return true;
		}
	}
?>