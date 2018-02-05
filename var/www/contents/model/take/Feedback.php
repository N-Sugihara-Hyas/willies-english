<?php

	addModel('ModelDB');

	/*
	*	マンスリーフィードバック
	*/
	class TakeFeedback extends ModelDB{
	var $tableName = 'take_feedback';
	
		function joinTakeBase(){
			$this->addJoins(
				array('model' => 'take/Base')
			);
		}
		function joinMemberBase(){
			$this->addJoins(
				array('model' => 'member/Base')
			);
		}

		function setFormAdmin(){
			$this->arrayColum['member_base_id'] = array(
				'type' => 'hidden',
				'list' => 0,
				'search' => false,
			);
			$this->arrayColum['subject'] = array(
				'type' => 'text',
				'name' => 'Subject',
				'form' => 'class="textBig"',
			);
			$this->arrayColum['body'] = array(
				'name' => 'Body',
				'type' => 'textarea',
				'list' => 0,
				'search' => false,
				'form' => 'style="width:100%;height:65em;"',
			);

			unset($this->arrayColum['type']);
			unset($this->arrayColum['feedback']);
		}

	}
?>