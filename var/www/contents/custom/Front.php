<?php

/*
*	管理画面用のベースクラスの改造版
*/
class CustomFront extends BaseAction{
var $dirRoot = '';


	function common(){

	}

	/*
	*	管理画面の表示が行われる全てで処理
	*/
	function getCommon($now=''){
		$this->addModel(array('member/Base'));
		$this->MemberBase->addModelTool('Login');

		if (!$this->arrayUser = $this->MemberBase->checkAuth()){
			$this->setRedirect('login');
		}
		
		$this->addModel(array('member/Reserve', 'take/Reserve', 'master/News', 'master/NewsCard', 'teaching/Base'));

		//場合によっては、初期設定をやらせる
		if (!$this->arrayUser['isSetting']){
			if ($now != 'first'){$this->setRedirect('mypage/setting/first/');}
		}else{
			if ($now == 'first'){
				if (isset($this->isFirstNg)){
					$this->setRedirect('mypage/');
				}
			}

			$this->addModel(array('teaching/Base', 'cource/Base', 'cource/Style', 'take/Base', 'card/Base'));

			//初期設定終了後は様々なデータの取得
			$arraySideCourceStyle = $this->CourceStyle->getDataUID($this->arrayUser['cource_style_id'])->getData();


			$this->set('arraySideCourceBase', $this->CourceBase->getDataUID($this->arrayUser['cource_base_id'])->getData());
			$this->set('arraySideCourceStyle', $arraySideCourceStyle);
			$this->set('arrayTakeBase', $this->TakeBase->getDataUID($this->arrayUser['take_base_id'])->getData());
			$this->set('scheduleName', $this->TakeBase->getFunctionDataOwn('Schedule', $this->arrayUser['cource_schedule_id']));

			if ($this->arrayUser['dateChange'] == date('Ym')){
				$this->set('isChange', false);
			}else{
				$this->set('isChange', true);
			}


			
			if (!$arraySideCourceStyle['weekTake']){
				//レッスンの予約が可能かどうか
				if ($this->MemberReserve->isReserveType($this->arrayUser, 1, $arraySideCourceStyle)){
					$this->set('isLesson', true);
				}

			}


			//音読の判定
			if ($this->MemberReserve->isReserveType($this->arrayUser, 3, array())){
				$this->set('isDaily', true);
			}
		}

		$this->set('arrayUser', $this->arrayUser);

		//いずれ他言語化対応を考えて
		$this->addLiblary('inoutput/Language');
		$this->Lang = new InoutputLanguage($this->arrayDir['dirProgram'] . 'template/admin/la/', 'ja');


		//カードの新着のチェック
		$this->set('arrayCardNew', $this->MasterNewsCard->getMyCardOpen($this->arrayUser['id'])->getData());
		
		//メニュー取得
		$this->addModel(array('member/Menu'));
		$this->set('arrayMenu', $this->MemberMenu->getData()->getDataAll());
		
		$this->set('menu', 0);
		
		//教材の情報取得
		$arrayType = $this->TeachingBase->getFunctionData('Teaching');
		foreach ($arrayType as $key => $value){
			$id = $this->arrayUser[strtolower($value['value'])];
			
			if ($id){
				$arrayTextBook[$value['value']] = $this->TeachingBase->getDataUID($id)->getData();
			}
		}		
		
		$this->set('arrayTextBook', $arrayTextBook);
		
		//print_R($arrayTextBook);
	}

	/*
	*	担任制か？
	*/
	function isTake(){
		if (!$this->arrayUser['take_base_id']){
			return false;
		}

		return true;
	}

}
?>