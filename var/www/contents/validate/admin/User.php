<?php

class ValidateAdminUser extends Validate{
	var $validate = array(
		'name' => array(
			array(
				'type' => 'NonSpace',
				'message' => '未入力です。'
			),
		),
		'loginID' => array(
			array(
				'type' => 'NonSpace',
				'message' => '未入力です。'
			),
			array(
				'type' => 'checkEmail',
				'message' => '同一のIDが存在します'
			),
		),


		'email' => array(
			array(
				'type' => 'NonSpace',
				'message' => '未入力です。'
			),
			array(
				'type' => 'Mail',
				'message' => 'メールアドレスはメール形式で入力して下さい。'
			),
			array(
				'type' => 'checkEmail',
				'message' => '同一のメールアドレスが存在します'
			),
		),

		'pass' => array(
			array(
				'type' => 'NonSpace',
				'message' => 'パスワードが未入力です。'
			),
			array(
				'type' => 'English',
				'message' => 'パスワードは半角英数字で入力して下さい。'
			),
			array(
				'type' => 'StringMax',
				'num' => '12',
				'message' => 'パスワードは12文字以内で入力して下さい。'
			),
			array(
				'type' => 'Conf',
				'conf' => 'passConf',
				'message' => 'パスワードは確認用と同一で入力して下さい。'
			),

		),


	);
	
	function checkEmail($strCheck, $arrayError, $key){

		$this->model->addQuery('email', $strCheck);

		
		if ($this->model->getUID()){
			$this->model->addQuery('id <>', $this->model->getUID());
		}

		if ($this->model->getData()->getData()){
			return $arrayError['message'];
		}
		
	}
	function checkLoginID($strCheck, $arrayError, $key){

		$this->model->addQuery('loginID', $strCheck);

		
		if ($this->model->getUID()){
			$this->model->addQuery('id <>', $this->model->getUID());
		}

		if ($this->model->getData()->getData()){
			return $arrayError['message'];
		}
		
	}


}

?>
