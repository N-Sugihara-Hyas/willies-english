<?php

/*
*	管理画面用のベースクラスの改造版
*/
class CustomAdminPlus extends BaseAction{
var $dirRoot = 'admin';


	function common(){

	}

	/*
	*	管理画面の表示が行われる全てで処理
	*/
	function getCommon(){
		$this->addModel(array('admin/User', 'take/Feedback'));

		$this->AdminUser->addModelTool('Login');

		if (!$this->arrayUser = $this->AdminUser->checkAuth()){
			$this->setRedirect('');
		}

		$this->set('my', substr($_SERVER['REQUEST_URI'], 1));
		$this->set('arrayUser', $this->arrayUser);

		$this->addLiblary('inoutput/Language');
		$this->Lang = new InoutputLanguage($this->arrayDir['dirProgram'] . 'template/admin/la/', getVar($this->arrayUser, 'la'));
		$this->LangMenu = new InoutputLanguage($this->arrayDir['dirContents'] . 'conf/la/menu/', getVar($this->arrayUser, 'la'));
		$this->LangPage = new InoutputLanguage($this->arrayDir['dirContents'] . 'conf/la/page/', getVar($this->arrayUser, 'la'));

		if ($this->arrayUser['adminType'] == 2){
		//副管理人の見れる箇所
			$arrayPage = array(
				'admin/messageTake/',
				'admin/sch/',
				'admin/take/',
				'admin/customer/',
				'admin/communication/',
			);

			$isOK = false;
			foreach ($arrayPage as $item){
				if ($item == $this->arrayAction['dir']){
					//給料関連だけは特殊
					if ($this->arrayAction['a'] != 'allowance'){
						$isOK = true;
					}
				}
			}

			if (!$isOK){
				$this->setRedirect('');
			}
		}

		//20分後の予約情報を取得
		/*$this->addModel(array('take/Reserve'));
		$this->TakeReserve->joinTakeBase();
		$this->set('arrayHeaderMessage', $this->TakeReserve->getStandby()->getDataAll());*/

		//FeedBackの未読の取得
		$this->TakeFeedback->addQuery('isOpen', 0);
		$this->set('countFeedback', $this->TakeFeedback->getData()->getCount());
	}

}
?>