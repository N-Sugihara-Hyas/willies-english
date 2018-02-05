<?php

	addModel('ModelDB');

	/*
	*	サプリのクラス
	*/
	class CompanyMember extends ModelDB{
	var $tableName = 'company_member';
	var $uid = '';
	var $order = 'company_base_id';
	var $group = '*';
	
		function joinMemberBase(){
			$this->addJoins(array('model' => 'member/Base'));
		}
		function joinTakeBase(){
			$this->addJoins(
				array('model' => 'take/Base', 'on' => 'take_base_id=take_base.id')
			);
		}
		function joinCourceBase(){
			$this->addJoins(
				array('model' => 'cource/Base', 'on' => 'cource_base_id=cource_base.id')
			);
		}
		function joinCourceStyle(){
			$this->addJoins(
				array('model' => 'cource/Style', 'on' => 'cource_style_id=cource_style.id')
			);
		}
		function joinTakeReserve(){
			$this->addJoins(
				array('model' => 'take/Reserve', 'on' => 'company_member.member_base_id=take_reserve.member_base_id')
			);
		}
		
		function getCompanyMember($cid, $mid){
			$this->addQuery('company_base_id', $cid);
			$this->addQuery('member_base_id', $mid);

			return $this->getData();
		}
		
		function getMemberAll($cid){
			$this->addQuery('company_base_id', $cid);
			
			return $this->getData();
		}
	}

?>