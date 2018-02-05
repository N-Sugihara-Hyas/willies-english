<?php

/*
*	ログインの処理
*/
class PluginLogin extends Plugin{

	/*
	*	ログインされているかのチェック処理
	*	@params $isRedirect リダイレクトされるか？
	*/
	function checkAuthBase($isRedirect=true){
		if (!isset($this->modelNameLogin)){
			if ($isRedirect){
				$this->setRedirect('login');
			}
		}

		if (!isset($this->modelNameLogin)){
			if ($isRedirect){
				$this->setRedirect('login');
			}else{
				return;
			}
		}

		$modelNameLogin = $this->modelNameLogin;

		$this->addLiblary('modelTool/Login');
		$MoselToolLogin = new ModelToolLogin($this->$modelNameLogin);

		//ログインされているか？
		if (!$MoselToolLogin->checkAuth()){
			if ($isRedirect){
				$this->setRedirect('login');
			}
		}

		$this->arrayUser = $MoselToolLogin->model->arrayData;
	}

	function _checkAuto(){
		if (isset($this->modelNameLogin) ){
			$modelNameLogin = $this->modelNameLogin;

			$this->addLiblary('modelTool/Login');

			$MoselToolLogin = new ModelToolLogin($this->$modelNameLogin);
			return $MoselToolLogin->checkAuto();
		}
	}

	function _auth($id, $pass){
		$modelNameLogin = $this->modelNameLogin;

		$this->addLiblary('modelTool/Login');

		$MoselToolLogin = new ModelToolLogin($this->$modelNameLogin);

		if (!strpos($id, '@')){
			$MoselToolLogin->arrayLogin['loginID'] = $id;
		}else{
			$MoselToolLogin->arrayLogin['email'] = $id;
		}

		$MoselToolLogin->arrayLogin['pass'] = $pass;

		//次回は自動ログインさせるか？
		if (isset($this->arrayPost['auto'])){
			$MoselToolLogin->isAuto = true;
		}

		return $MoselToolLogin->auth();
	}

	function logout(){
		$modelNameLogin = $this->modelNameLogin;

		$this->addLiblary('modelTool/Login');

		$MoselToolLogin = new ModelToolLogin($this->$modelNameLogin);
		$MoselToolLogin->logout();

	}
}

?>