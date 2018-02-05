<?php

/***********************************************************
*	管理画面のログイン
*/
class Action extends CustomAdminPlus{
var $arrayForm = array('id', 'pass', 'auto');

	/***********************************************************
	 * 追加でrequireするもの
	 */
	function addRequire(){

	}

	/***********************************************************
	*	ログアウト処理
	*/
	function setProgram(){
		$this->checkAuthBase();
		$this->logout();
		
		$this->setRedirect('');
	}
}

?>