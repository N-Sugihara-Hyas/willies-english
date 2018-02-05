<?php

	addModel('ModelDB');

	/*
	*	メールログのクラス
	*/
	class MasterMailLog extends ModelDB{
	var $tableName = 'master_mail_log';

		function joinMemberBase(){
			$this->addJoins(
				array('model' => 'member/Base')
			);
		}
	
		function addLog($email, $subject, $body, $mID, $tID=0){
			$this->arrayData['email'] = $email;
			$this->arrayData['subject'] = $subject;
			$this->arrayData['body'] = $body;
			
			if ($tID){
				$this->arrayData['take_base_id'] = $tID;
			}
			
			$this->arrayData['member_base_id'] = $mID;

			$this->commit($this->arrayData);
		}


	}
?>