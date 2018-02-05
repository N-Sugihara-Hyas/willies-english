<?php

	addModel('ModelDB');

	/*
	*	サプリのクラス
	*/
	class MasterNewsCard extends ModelDB{
	var $tableName = 'master_news_card';
	var $order = 'dateDay DESC';

		function addCard($arrayCard, $type, $mid){
			$arrayData['card_base_id'] = $arrayCard['id'];
			$arrayData['type'] = $type;
			$arrayData['member_base_id'] = $mid;
			$arrayData['dateDay'] = date('Y-m-d');

			//スクールカードの場合
			if ($type == 3){
				//対象のユーザー取得
				$MemberBase = $this->getModel('member/Base');
				if ($arrayCard['cource_base_id']){
					$MemberBase->addQuery('cource_base_id', $arrayCard['cource_base_id']);
				}
				$dbGet = $MemberBase->getData();

				$arrayData['body'] = 'スクール CARD にアップデートがあります。';

				while ($item = $dbGet->getData()){
					$arrayData['member_base_id'] = $item['id'];
					$this->commit($arrayData);
				}
			}else{
				$arrayData['body'] = 'フィードバック CARD にアップデートがあります。';

				$this->commit($arrayData);
			}
			
		}

		function addTest($cid, $mid){
			$arrayData['card_base_id'] = $cid;
			$arrayData['type'] = 4;
			$arrayData['member_base_id'] = $mid;
			$arrayData['dateDay'] = date('Y-m-d');

			$arrayData['body'] = '実力確認テストにアップデートがあります';
			$this->commit($arrayData);			
		}
		
		function getMy($mid){
			$this->addQuery('type IS NULL');
			$this->addQuery('OR member_base_id', $mid);

			return $this->getData();
		}
		function getMyCard($mid){
			$this->addQuery('type IS NOT NULL');
			$this->addQuery('member_base_id', $mid);

			return $this->getData();
		}
		function getMyCardOpen($mid){
			$this->addQuery('type IS NOT NULL');
			$this->addQuery('member_base_id', $mid);
			$this->addQuery('isOpen', 0);

			return $this->getData();
		}

		function setOpen($mid, $cid){
			$this->addQuery('member_base_id', $mid);
			$this->addQuery('card_base_id', $cid);

			$this->setData(array('isOpen' => 1));
		}
	}
?>