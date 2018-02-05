<?php

	addModel('ModelDB');

	/*
	*	カードのクラス
	*/
	class CardBase extends ModelDB{
	var $tableName = 'card_base';
	var $order = 'card_base.created DESC';

		function joinTakeBase(){
			$this->addJoins(array('model' => 'take/Base'));
		}
		function joinTakeBase2(){
			$this->addJoins(array('model' => 'take/Base', 'member_base.take_base_id2222222=take_base.id'));
		}
		
		function joinMemberBase(){
			$this->addJoins(array('model' => 'member/Base'));
		}
		function joinAdminLogin(){
			$this->addJoins(array('model' => 'admin/User'));
		}
		function joinCardDetails(){
			$this->addJoins(array('model' => 'card/Details', 'on' => 'card_base.id=card_details.card_base_id'));
		}
		function joinCardAnser($mid=0){
			$this->addJoins(array('model' => 'card/Anser', 'on' => 'card_details.id=card_anser.card_details_id AND card_anser.member_base_id=' . $mid));
		}
		function joinCardAnser2(){
			$this->addJoins(array('model' => 'card/Anser', 'on' => 'card_details.id=card_anser.card_details_id'));
		}
		/*
		*	星の判定を入れる
		*/
		function getMyStar($star,$mid, $type=0, $cid=0, $cbid=0){
			$this->joinCardDetails();
			$this->joinCardAnser();

			if ($star){
				$this->addQuery('card_anser.isOK', 1);
			}else{
				$this->addQuery('card_anser.isOK', 0);
				//$this->addQuery('OR card_anser.isOK IS NULL');
			}


			return $this->getMy($mid, $type, $cid, $cbid);
		}

		/*
		*	自分が見れるカード
		*/
		function getMy($mid, $type=0, $cid=0, $cbid){
			if ($type){
				$this->addQuery('card_base.type', $type);
			}
			if ($cid){
				$this->addQuery('card_base.id', $cid);
			}

			if ($type != 3){
				$this->addQuery('card_base.member_base_id', $mid);
			}
			
			if ($cbid){
				$this->addQuery('(0');
				$this->addQuery('OR cource_base_id', $cbid);
				$this->addQuery('OR cource_base_id', 0);
				$this->addQuery('OR 0)');

			}

			$this->addQuery('state', 1);

			$this->target = '*,card_base.*';
			$this->addCardDetails($mid);

			return $this->getData();
		}

		/*
		*	カードの付属数、正解数を取得させる
		*/
		function addCardDetails($mid=0){
			$this->joinCardDetails();

			if ($mid){
				$this->joinCardAnser($mid);
			}

			$this->target.= ',COUNT(DISTINCT card_details.id) as countCard';

			if ($mid){
				$this->target.=',SUM(card_anser.isOK) as countAnser';
			}

		}
		/*
		*	カードのユーザーのプレイ数の取得
		*/
		function addCardMember(){
			$this->joinCardDetails();
			$this->joinCardAnser2();
			$this->target.= ',COUNT(DISTINCT card_anser.member_base_id) as countMember';
		}

		function setPage($page){
			$this->pageCard = $page;
			$this->setSession('cardPage', $this->pageCard);
		}

		function getPage(){
			$this->pageCard = $this->getSession('cardPage');

			return $this->pageCard;
		}

		/*
		*	カードのセッションから取得
		*/
		function getCardAll(){
			if (!isset($this->arrayCardDetails)){
				$this->arrayCardDetails = $this->getSession('arrayCardDetails');
				$this->pageCard = $this->getSession('cardPage');
			}

			if (!$this->pageCard){$this->pageCard = 0;}


			return $this->arrayCardDetails;
		}

		/*
		*	カードのセッションから現ページのデータの取得
		*/
		function getCard(){
			$this->getCardAll();
			
			if (isset($this->arrayCardDetails[$this->pageCard])){
				return $this->arrayCardDetails[$this->pageCard];
			}else{
				return '';
			}
		}

		/*
		*	カードのセッションへのロード
		*/
		function loadCard($mid, $bid, $type){
			$this->clearCard();

			$CardDetails = $this->getModel('card/Details');
			$dbGet = $CardDetails->getMyBase($mid, $bid, $type);

			while ($item = $dbGet->getData()){
				$arrayInput['body1'] = $item['body1'];
				$arrayInput['body2'] = $item['body2'];

				$this->addCard($arrayInput);
			}
		}

		/*
		*	カードのセッションへの追加
		*/
		function addCard($arrayInput){
			$this->getCardAll();

			$this->arrayCardDetails[$this->pageCard] = $arrayInput;

			$this->pageCard++;
			$this->setSession('cardPage', $this->pageCard);
			$this->setSession('arrayCardDetails', $this->arrayCardDetails);

		}

		/*
		*	カードのセッションの削除(全て)
		*/
		function clearCard(){
			$this->setSession('cardPage', 0);
			$this->setSession('arrayCardDetails', array());
		}


		/*
		*	カードのセッションの削除
		*/
		function delCard($pid){
			$this->getCardAll();

			unset($this->arrayCardDetails[$pid]);
			
			for ($i = $pid; $i <= 500;$i++){
				if (!empty($this->arrayCardDetails[$i+1])){
					$this->arrayCardDetails[$i] = $this->arrayCardDetails[$i+1];
				}else{
					break;
				}
			}
			unset($this->arrayCardDetails[$i]);
			
			$this->setSession('arrayCardDetails', $this->arrayCardDetails);
		}

		function createCard($cardName, $mid, $type, $tid=0, $arrayExt=array()){
			$arrayData['state'] = 1;

			if ($type){
				//タイプが選択されてる場合
				if ($type == 1){
					$arrayData['cardName'] = $cardName;
					$arrayData['member_base_id'] = $mid;
					$arrayData['type'] = $type;
					$arrayData['take_base_id'] = $tid;
					$arrayData['free'] = $arrayExt['comment'];
					$arrayData['temp'] = $arrayExt['temp'];
					
					if (!empty($arrayExt['modified'])){
						$arrayData['date'] = $arrayExt['modified'];
					}
					
					//編集モードか？
					if ($this->getUID()){
						$cid = $this->getUID();
						$arrayData['id'] = $cid;
					}	
						
					$cid = $this->commit($arrayData);
					
				}elseif ($arrayExt){
					$arrayData['cource_base_id'] = $arrayExt['cource_base_id'];
					$arrayData['state'] = $arrayExt['state'];
					$arrayData['fee'] = $arrayExt['fee'];
					$arrayData['feeType'] = $arrayExt['feeType'];
					$arrayData['free'] = $arrayExt['free'];	
					
					if (isset($arrayExt['admin_login_id'])){
						$arrayData['admin_login_id'] = $arrayExt['admin_login_id'];
					}
								
					$this->setDataUID($arrayExt['card_base_id'], $arrayData);
					$cid = $arrayExt['card_base_id'];
				}elseif($type == 2){
					$cid = $cardName;
				}
			}else{
				//タイプが選択されてない場合
				$arrayData['cardName'] = $cardName;
				
					//編集モードか？
					$arrayData['id'] = $cid = $this->getUID();
					$cid = $this->commit($arrayData);
			}
			
			
			$this->getCardAll();

			$CardDetails = $this->getModel('card/Details');

			$CardDetails->addQuery('card_base_id', $cid);
			$arrayDetails = $CardDetails->getData()->getDataAll();

			//削除&追加ではダメなため、それの対応
			$i = 0;
			foreach ($this->arrayCardDetails as $item){
				$arrayDetails[$i]['card_base_id'] = $cid;
				$arrayDetails[$i]['body1'] = $item['body1'];
				$arrayDetails[$i]['body2'] = $item['body2'];

				$CardDetails->commit($arrayDetails[$i]);
				$i++;
			}

			//自分で制作以外はお知らせに追加
			if ($type != 2){
				if ($arrayData['state'] == 1){
					$arrayData['id'] = $cid;
					$MasterNews = $this->getModel('master/NewsCard');
					$MasterNews->addCard($arrayData, $type, $mid);
				}
			}

			$this->clearCard();
			
			return $cid;
		}

		function getTarget($objData){			
			$this->addQuery('date', $objData['date']);
			$this->addQuery('member_base_id', $objData['member_base_id']);
			
			return $this->getData();
		}
		
	}
?>