<?php

require_once 'Front.php';

/*
*	管理画面用のベースクラスの改造版
*/
class CustomFrontCard extends CustomFront{
var $dirRoot = '';


	function common(){

	}

	/*
	*	管理画面の表示が行われる全てで処理
	*/
	function getCommon($now='', $isFree=false){
		parent::getCommon($now);

		$this->set('isCard', true);
		
		//使用権利があるか？？
		if (($this->arrayUser['state'] < 4) || ($this->arrayUser['isPayCard'] == 1)){
			$this->set('isPayCard', true);	
		}else{
			if (!$isFree){
				//DropOutの場合は退会予定日から一ヶ月後を使用権利とする
				$this->addLiblary('inoutput/Date');
				
				$InoutputDate = new InoutputDate();
				$timeLimit = time();
				$timeUser = strtotime($InoutputDate->getDateNext($this->arrayUser['dateUnRegist'], 'm', 1));

				if ($timeLimit > $timeUser){
					$this->setRedirect('card/free');
				}
			}
			
			$this->set('isPayCard', false);	
		}
	}


}
?>