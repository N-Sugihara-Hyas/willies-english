<?php

	addModel('ModelDB');

	/*
	*	管理者関連のクラス
	*/
	class AdminUser extends ModelDB{
	var $tableName = 'admin_login';
	var $tableNameSession = 'admin_session';
	var $loginID = 'admin_login_id';
	var $dateLastLogin = 'dateLastLogin';

		/*
		*	パスワードの暗号化
		*	@params $pass 変換元
		*	@return 変換後パスワード
		*/
		function getEncode($pass){
			$this->addLiblary('securty/Code');
			
			$SecurtyCode = new SecurtyCode($this->arraySetting['secretKey']);
			return $SecurtyCode->getEncode($pass);
		}

		/*
		*	パスワードの複合
		*	@params $pass 複合元
		*	@return 複合後パスワード
		*/
		function getDecode($pass){
			$this->addLiblary('securty/Code');
			
			$SecurtyCode = new SecurtyCode($this->arraySetting['secretKey']);
			return $SecurtyCode->getDecode($pass);
		}



	}

?>