<?php

	/*
	*	支払いの無い人間の体験終了の処理
	*/
	$this->addModel(array('member/Base', 'cource/Style'));
		
	if (isset($this->arraySetting['isCron'])){
		if (date('w') == 0){
			$this->MemberBase->addQuery('isPay', 1);
			$this->MemberBase->addQuery('state <>', 10);
			
			$dbGet = $this->MemberBase->getData();
	
			while($item = $dbGet->getData()){
				$this->CourceStyle->addQuery('id', $item['cource_style_id']);
				$arrayStyle = $this->CourceStyle->getData()->getData();
	
				//担任制ではない場合処理
				if (!$arrayStyle['weekTake']){
					if ($item['countLesson'] < $this->arraySetting['maxCountLesson']){					
						$item['countLesson']+=$arrayStyle['weekCount'];
						
						$arrayMember['id'] = $item['id'];
						$arrayMember['countLesson'] = $item['countLesson'];
						
						$this->MemberBase->commit($arrayMember);
					}
				}else{
					$arrayMember['id'] = $item['id'];
					$arrayMember['countLesson'] = 0;
					$this->MemberBase->commit($arrayMember);
				}
	
				//グループレッスンの場合処理(ここ危険なので、復旧の際は要チェック)
				/*if ($item['isPayDaily']){
					if ($item['countDaily'] < $this->arraySetting['maxCountLesson']){					
						$item['countDaily']+=$arrayStyle['groupCount'];
						
						$arrayMember['id'] = $item['id'];
						$arrayMember['countDaily'] = $item['countDaily'];
	
						echo $arrayMember['id']  . '<br />';
						$this->MemberBase->commit($arrayMember);
					}
				}*/
	
			}
		}
	}
	
	exit();
		
?>