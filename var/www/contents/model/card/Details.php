<?php

	addModel('ModelDB');

	/*
	*	カードの詳細のクラス
	*/
	class CardDetails extends ModelDB{
	var $tableName = 'card_details';
	var $order = 'card_details.id ASC';

		function joinCardBase(){
			$this->addJoins(array('model' => 'card/Base'));
		}
		function joinCardAnser($mid){
			$this->addJoins(array('model' => 'card/Anser', 'on' => 'card_details.id=card_anser.card_details_id AND card_anser.member_base_id=' . $mid));
		}

		function getMyBase($mid, $bid, $type){
			$this->target.= ',card_details.*';

			$this->joinCardBase();


			if ($type != 3){
				$this->addQuery('card_base.member_base_id', $mid);
			}

			$this->addQuery('card_base_id', $bid);
			
			$this->joinCardAnser($mid);

			return $this->getData();
		}

		/*
		*	星の判定を入れる
		*/
		function getMyStar($star,$mid, $did, $type=0){
			if ($star){
				$this->addQuery('card_anser.isOK', 1);
			}else{
				$this->addQuery('card_anser.isOK', 0);
				$this->addQuery('OR card_anser.isOK IS NULL');
			}

			$this->joinCardAnser($mid);
			
			return $this->getMyBase($mid, $did, $type);
		}


		function getMy($mid, $did){
			$this->target.= ',card_details.*';

			$this->joinCardBase();

			$this->addQuery('card_base.member_base_id', $mid);
			$this->addQuery($this->tableName . '.id', $did);

			return $this->getData();
		}

	}
?>