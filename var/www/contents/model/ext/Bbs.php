<?php

	addModel('ModelDB');

	/*
	*	お問合せ
	*/
	class ExtBbs extends ModelDB{
	var $tableName = 'ext_bbs';

		function joinTakeBase(){
			$this->addJoins(array('model' => 'take/Base'));
		}
		
		function getFull($dbget, $mid, $tid){
			$MemberBase = $this->getModel('member/Base');
			$TakeBase = $this->getModel('take/Base');
			$ExtBbsLike = $this->getModel('ext/BbsLike');
			$ExtBbsComment = $this->getModel('ext/BbsComment');
			
			$arrayList = array();
			
			
			while ($objData = $dbget->getData()){
				if ($objData['take_base_id']){
					$objData['objMember'] = $TakeBase->getDataUID($objData['take_base_id'])->getData();
				}
				if ($objData['member_base_id']){
					$objData['objMember'] = $MemberBase->getDataUID($objData['member_base_id'])->getData();
					if ($objData['objMember']['bbsType'] == 0){
						$objData['objMember']['nickname'] = 'ID:' . $objData['objMember']['id'];	
					}
					if ($objData['objMember']['bbsType'] == 1){
						$objData['objMember']['nickname'] = $objData['objMember']['memberNameSecoundEnglish'] . '&nbsp;' . $objData['objMember']['memberNameFirstEnglish'];	
					}

				}

				//いいねしたかの取得
				if ($ExtBbsLike->getLike($objData['id'], $mid, $tid)->getData()){
					$objData['isLike'] = false;
				}else{
					$objData['isLike'] = true;
				}

				//コメント
				$ExtBbsComment->addQuery('ext_bbs_id', $objData['id']);
				$objData['arrayComment'] = $ExtBbsComment->getFull($ExtBbsComment->getData(), 0,0);
				
				array_push($arrayList, $objData);
			}
			
			return $arrayList;
		}
		
	}
?>