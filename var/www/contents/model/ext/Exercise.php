<?php

	addModel('ModelDB');

	/*
	*	英語道場
	*/
	class ExtExercise extends ModelDB{
	var $tableName = 'ext_exercise';

		function joinMemberBase(){
			$this->addJoins(array('model' => 'member/Base'));
		}

	}
?>