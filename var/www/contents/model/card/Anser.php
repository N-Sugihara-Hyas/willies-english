<?php

	addModel('ModelDB');

	/*
	*	カードの正解のクラス
	*/
	class CardAnser extends ModelDB{
	var $tableName = 'card_anser';

		function getMy($mid, $did){
			$this->addQuery('card_anser.member_base_id', $mid);
			$this->addQuery('card_anser.card_details_id', $did);

			return $this->getData();
		}

	}
?>