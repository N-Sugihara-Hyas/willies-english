<?php

	addModel('ModelDB');


	/*
	*	コースのクラス
	*/
	class GroupReserve extends ModelDB{
	var $tableName = 'group_reserve';

		function joinCourceBase(){
			$this->addJoins(array('model' => 'cource/Base', 'on' => 'group_base.cource_base_id=cource_base.id'));	
		}
		function joinGroupBase(){
			$this->addJoins(array('model' => 'group/Base'));	
		}
		function joinTakeBase(){
			$this->addJoins(array('model' => 'take/Base', 'on' => 'group_base.take_base_id=take_base.id'));	
		}		
		
		function getDate($dateStart, $dateEnd, $gID=0, $level=0, $cid=0){
			$timeStart = strtotime($dateStart);
			$timeEnd = strtotime($dateEnd);
			
			$arrayResult = array();
			
			if (($level) || ($cid)){
				$this->joinGroupBase();				
			}
			if ($level){
				$this->addQuery('level', $level);
			}
			if ($cid){
				$this->addQuery('cource_base_id', $cid);
			}
			
			$this->addQuery($this->tableName . '.countMax > ' . $this->tableName . '.count');

			$this->addQuery('(0');			
			for ($i = $timeStart; $i <= $timeEnd; $i+=1800){
				$date =  date('YmdHi', $i);
				$this->addQuery('OR dateStart', $date);
			}
			$this->addQuery('1)');			

			//30分以上先の予約のみを対象にする
			$this->addQuery('dateStart>=', date('YmdHi', time() + (1800)));	

			if ($gID){
				$this->addQuery($this->tableName . '.id', $gID);
			}			
			
			$dbGet = $this->getData();
			
			while ($item = $dbGet->getData()){
				$date = date('YmdHi', strtotime($item['dateStart']));

				$arrayResult[$date][$item['id']] = $item;
			}
			
			
			return $arrayResult;
		}
		
		//予約の追加
		function addReserve($dateStart, $dateEnd, $gID, $tID, $countMax){			
			$GroupBase = $this->getModel('group/Base');
			$arrayBase = $GroupBase->getDataUID($gID)->getData();
						
			$arrayData['dateStart'] = $dateStart;
			$arrayData['dateEnd'] = $dateEnd;
			$arrayData['take_base_id'] = $tID;
			$arrayData['countMax'] = $countMax;
			$arrayData['group_base_id'] = $gID;
			$arrayData['count'] = 0;

			$rid = $this->commit($arrayData);
			
		}
		
		function getMy($mid){
			$this->target = '*,' . $this->tableName . '.*';
			$this->joinGroupBase();
			
			$this->addQuery('date >', date('YmdHi'));
			$this->addQuery('member_base_id', $mid);
			
			return $this->getData();
		}

		/*
		*	対象の講師の情報取得
		*	@paramse $tID 該当講師の指定 $dateStart 開始日　$dateEnd 終了日
		*/
		function getScheduleTake($tID=0, $dateStart='', $dateEnd=''){
			$this->joinGroupBase();

			if ($tID){
				$this->addQuery('group_base.take_base_id', $tID);
			}

			if ($dateStart){
				$this->addQuery($this->tableName . '.dateStart >=', $dateStart);
			}

			if ($dateEnd){
				$this->addQuery($this->tableName . '.dateStart <=', $dateEnd);
			}


			return $this->getData();
		}
	}
?>