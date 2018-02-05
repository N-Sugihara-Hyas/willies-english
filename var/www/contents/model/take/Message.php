<?php

	addModel('ModelDB');

	/*
	*	講師のメッセージのクラス
	*/
	class TakeMessage extends ModelDB{
	var $tableName = 'take_message';

		function joinTakeBaseTo(){
			$this->addJoins(array('model' => 'take/Base', 'on' => 'take_message.to_id=take_base.id'));
		}
		function joinTakeBaseFrom(){
			$this->addJoins(array('model' => 'take/Base', 'on' => 'take_message.from_id=take_base.id'));
		}

		function joinTakeMessageOpen($mid){
			$this->addJoins(array('model' => 'take/MessageOpen', 'on' => 'take_message.id=take_message_open.take_message_id AND take_message_open.to_id=' . $mid));
		}
		

	}
?>