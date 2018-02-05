<?php

	addModel('ModelDB');

	/*
	*	コースのクラス
	*/
	class GroupReserveDetails extends ModelDB{
	var $tableName = 'group_reserve_details';

		function joinGroupReserve(){
			$this->addJoins(array('model' => 'group/Reserve'));	
		}
		function joinGroupBase(){
			$this->addJoins(array('model' => 'group/Base', 'on' => 'group_reserve.group_base_id=group_base.id'));	
		}
		function joinMemberBase(){
			$this->addJoins(array('model' => 'member/Base'));	
		}	
		
		function getMy($mid){
			$this->target = '*,' . $this->tableName . '.*';
			$this->joinGroupReserve();
			$this->joinGroupBase();
			
			$this->addQuery('group_reserve.dateStart >', date('YmdHi'));
			$this->addQuery('member_base_id', $mid);
			
			
			return $this->getData();
		}
		
		/*
		*	自分のスケジュールの取得
		*	@paramse $mID 該当ユーザーの指定 $isHistory 過去も取得
		*/
		function getScheduleMy($mID){
			$this->target = '*,' . $this->tableName . '.*';
			$this->joinGroupReserve();
			$this->joinGroupBase();
			
			$this->addQuery('group_reserve.dateStart >', date('YmdHi'));
			$this->addQuery('member_base_id', $mID);

			$arrayData = $this->getData();


			$GroupCancel = $this->getModel('group/Cancel');

			$arrayResult = array();

			$i = 0;
			while ($item = $arrayData->getData()){
				$arrayResult[$i] = $item;

				$arrayResult[$i]['isCancel'] = $GroupCancel->isCancel($item['member_base_id'], $item);

				$i++;
			}

 			return $arrayResult;
		}
		
		
		function getMyReserve($rid){
			$this->addQuery('group_reserve_id', $rid);
			
			return $this->getData();
		}

		function addReserve($rid, $mid){
			$arrayData['group_reserve_id'] =  $rid;
			$arrayData['member_base_id'] = $mid;

			$this->addData($arrayData);
			
			$GroupReserve = $this->getModel('group/Reserve');
			$GroupReserve->setDataUID($rid, array('count=count+1' => 'key'));
		}
		
		//予約ができるかのチェック
		function isReserveOK($mid, $point){
			if ($point <= 0){
				return false;
			}
			
			//未来に自分音予約があるか？
			$this->joinGroupReserve();
			$this->addQuery('dateStart >=', date('YmdHi'));
			$this->addQuery('member_base_id', $mid);
			
			$arrayData = $this->getData()->getData();
			
			if ($arrayData){
				return false;
			}
			
			return true;
		}
		
		//キャンセルの場合
		function setCancel($rid){
			$arrayData = $this->getDataUID($rid)->getData();
			$this->addQuery('id', $arrayData['id']);
			$this->delData();
			
			$GroupReserve = $this->getModel('group/Reserve');
			$GroupReserve->setDataUID($arrayData['group_reserve_id'], array('count=count-1' => 'key'));						
		}
	}
?>