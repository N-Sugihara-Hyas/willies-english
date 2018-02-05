<?php

	addModel('ModelDB');

	/*
	*	ユーザーの予約履歴のクラス
	*/
	class MemberReserve extends ModelDB{
	var $tableName = 'member_reserve';

		/*
		*	予約が取れるユーザーか
		*	@params $uid ユーザーのID $type 予約タイプ $arrayCourceStyle 受講プラン
		*	@return 予約が取れればtrue 取れなければfalse
		*/
		function isReserveType($arrayUser, $type, $arrayCourceStyle){
			$TakeReserve = $this->getModel('take/Reserve');

			if (!$type){return false;}

			if ($type == 1){
				//一回一回を予約する通常レッスン
				if ($arrayCourceStyle['weekTake']){
					//担任制は不可
					return false;
				}

				//レッスン回数が残っている場合はOK
				if ($arrayUser['countLesson'] > 0){
					return $TakeReserve->arrayType[$type];
				}


				return false;
			}

			if ($type == 2){
				$MemberCancel = $this->getModel('member/Cancel');

				if (!$MemberCancel->getSession('traialCancel') ){
					//振替予約の場合は振替ポイントが必須
					if ($arrayUser['countReturn'] < 1){
						return false;
					}
				}
			}

			if ($type == 3){
				//音読回数が残っている場合はOK
				if ($arrayUser['countDaily'] > 0){
					return $TakeReserve->arrayType[$type];
				}

				return false;
			}

			$TakeReserve = $this->getModel('take/Reserve');

			return $TakeReserve->arrayType[$type];
		}

		/*
		*	今月分の自分の情報取得
		*	@params $uid ユーザーのID $type 種類
		*	@return 今月分の情報
		*/
		function getDataNowMy($uid, $type){
			$this->addQuery('member_base_id', $uid);

			$this->addLiblary('inoutput/Date');
			$w = InoutputDate::getWeekCount(date('Y-m-d'));

			$this->addQuery('date', date('Ym') . $w);
			$this->addQuery('type',$type);

			return $this->getData();
		}


	}

?>