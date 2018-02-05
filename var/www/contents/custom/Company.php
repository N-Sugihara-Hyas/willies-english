<?php

/*
*	管理画面用のベースクラスの改造版
*/
class CustomCompany extends BaseAction{
var $dirRoot = 'company';


	function common(){

	}

	/*
	*	管理画面の表示が行われる全てで処理
	*/
	function getCommon($now=''){
		$this->addModel(array('company/Base', 'company/Member'));
		$this->addLiblary(array('securty/Code'));
		$this->CompanyBase->addModelTool('Login');

		if (!$this->arrayUser = $this->CompanyBase->checkAuth()){
			$this->setRedirect('login');
		}

		
		$this->set('SecurtyCode', new SecurtyCode($this->arraySetting['secretKey']));
	
		$this->set('arrayUser', $this->arrayUser);
		
		$this->CompanyMember->joinMemberBase();
		$this->CompanyMember->addQuery('company_base_id', $this->arrayUser['id']);
		$this->set('arraySideMember', $this->CompanyMember->getData()->getDataAll());
		
	
	}

}
?>