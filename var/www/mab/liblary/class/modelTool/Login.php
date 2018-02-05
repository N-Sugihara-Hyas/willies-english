<?php

	require_once dirname(__FILE__) . '/../securty/Session.php';
	require_once dirname(__FILE__) . '/../inoutput/String.php';

	$self->uidSession='id';
	$self->isAuto = false;
	$self->LIMIT_TIME_SESSION_ID = 1;	/*古いセッションID情報を更新するまでを分で指定*/
	$self->LIMIT_TIME_SESSION = 2;			/*古いセッション情報を削除するまでの日にちで指定*/


	$self->LoginSession = new ModelDB($this->tableNameSession);
	$self->LoginSession->uid = $this->uidSession;
	$self->loginUID = $this->tableName . '_' . $this->tID;

	/*
	*	ログイン処理
	*/
	$this->parent->auth = function($arrayLogin) use ($self){
		foreach ($arrayLogin as $key => $item){
			$self->addQuery($key, $item);
			
			if (!$item){
				return false;
			}
		}
		
		$arrayData = $self->getData()->getData();
		
		if ($arrayData){
			if (isset($self->dateLastLogin)){
				$arrayData[$self->dateLastLogin] = date('Y-m-d H:i:s');

				$id = $self->commit($arrayData);
			}
		

			//ログインが正常に行われた場合の処理
			$self->sid = $self->getSID();
			$self->LoginSession->arrayData[$self->loginUID] = $id;
			$self->LoginSession->arrayData['sid'] = $self->sid;
			$self->LoginSession->arrayData['ip'] = $_SERVER['REMOTE_ADDR'];
			$self->LoginSession->addData();

			$SessionLogin = new SecurtySession($self->modelName . $self->loginUID);
			$SessionLogin->arrayData['sid'] = $self->sid;
			$SessionLogin->commit();

			//自動ログインが行われている場合
			if ($self->isAuto){
				$self->addAuto(14);
			}

			return true;
		}

		return false;
	};

	/*
	*	ログインされているかのチェック処理
	*/
	$this->parent->checkAuth = function() use ($self){
		//セッションに自分のSIDがあるか？
		$SessionLogin = new SecurtySession($self->modelName .  $self->loginUID);
		$arraySessionLogin = $SessionLogin->getData();
		$self->sid = getVar($arraySessionLogin, 'sid');


		//自動ログイン設定(検討中)
		if (!$self->sid){return false;}
	
		$self->LoginSession->addQuery('sid', $self->sid);
		
		//存在すれば、今度は対象の管理ユーザーが存在するかのチェック
		if (!$arraySession = $self->LoginSession->getData()->getData()){
			return false;
		}

		if ($arrayUser = $self->getDataUID($arraySession[$self->loginUID])->getData()){
			//ログインされていると認識し、DBとセッション情報の更新
			$self->sid = $self->getSID();

			$arraySession['sid'] = $self->sid;
			$self->LoginSession->commit($arraySession);

			$SessionLogin->arrayData['sid'] = $self->sid;
			$SessionLogin->commit();

			//古いセッションデータは削除する(ここで行うほうが良いのか？)
			$limitTimeSession = time() - ($self->LIMIT_TIME_SESSION * 60 * 60 * 24);
			$limitDateSession = date('Y-m-d H:i:s', $limitTimeSession);

			$self->LoginSession->addQuery('modified <', $limitDateSession);
			$self->LoginSession->delData();

			return $arrayUser;
		}


		return false;
	};

	/*
	*	自動ログインの追加
	*/
	$this->parent->addAuto = function($numDay){
		$cSecurtySession = new SecurtySession($this->model->modelName . 'Remenber');
		$cSecurtySession->time = 60 * 60 * 24 * $numDay;
		$cSecurtySession->addData(array('auto' => $this->sid, 'time' => $numDay) );
	};

	/*
	*	自動ログインするかのチェック
	*/
	$this->parent->checkAuto = function(){
		//クッキーの取得
		$cSecurtySession = new SecurtySession($this->model->modelName .  'Remenber');
		$arrayData = $cSecurtySession->getData();


		//ある場合はセッションに設定
		if ($cSecurtySession->arrayData['auto']){
			if ($this->checkAuth($cSecurtySession->arrayData['auto']) ){
				$cSession = new SecurtySession($this->model->tableName . 'auto');
				$cSession->addData(array('sid' => $this->sid));

				return true;
			}
		}

		return false;
	};

	/*
	*	ログアウト処理
	*/
	$this->parent->logout = function() use($self){
		$SessionLogin = new SecurtySession($self->modelName . $self->loginUID);
		$arryaSession = $SessionLogin->getData();


		$self->LoginSession->addQuery('sid', $arryaSession['sid']);
		$self->LoginSession->delData();


		$SessionLogin->clear();

		//自動ログイン設定されていればクッキーも更新
		$cSecurtySession = new SecurtySession('adminLogin');
		$cSecurtySession->clear();

	};

	/*
	*	セッション情報の取得
	*/
	$this->parent->getSID = function(){
		return InOutputString::getRandomString(30) . time();
	};

	/*
	*	パスワードの暗号化
	*	@params $pass パスワード $securtyKey セキュリティキー
	*	@return 暗号化したパスワード
	*/
	$this->parent->changePass = function($pass, $securtyKey) use ($self){
		$self->addLiblary('securty/Code');

		//パスワードの暗号化
		$SecurtyCode = new SecurtyCode($securtyKey);
		$pass = $SecurtyCode->getEncode($pass);

		return $pass;
	};

?>