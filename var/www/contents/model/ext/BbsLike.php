<?php

	addModel('ModelDB');

	/*
	*	お問合せ
	*/
	class ExtBbsLike extends ModelDB{
	var $tableName = 'ext_bbs_like';

		function getLike($bid, $mid, $tid){
			$this->addQuery('ext_bbs_id', $bid);

			if ($mid){
				$this->addQuery('member_base_id', $mid);
			}
			if ($tid){
				$this->addQuery('take_base_id', $tid);
			}

			return $this->getData();
		}

		function addLike($bid, $mid, $tid){
			$objData['ext_bbs_id'] = $bid;

			if (!$this->getLike($bid, $mid, $tid)->getData()){
				if ($mid){
					$objData['member_base_id'] =  $mid;
				}
				if ($tid){
					$objData['take_base_id'] = $tid;
				}
				
				$this->commit($objData);
			}
			
			$this->addQuery('ext_bbs_id', $bid);
			$count = $this->getData()->getCount();
									
			$ExtBbs = $this->getModel('ext/Bbs');
			$ExtBbs->addQuery('id', $bid);
			$ExtBbs->setData(array('like' => $count));
		}

	}
?>