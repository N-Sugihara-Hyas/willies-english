<?php

class ValidateCompanyBase extends Validate{
	var $validate = array(
		'companyName' => array(
			array(
				'type' => 'NonSpace',
				'message' => '未入力です'
			),
			array(
				'type' => 'StringMax',
				'num' => 255,
				'message' => '全角で122文字以上で入力して下さい'
			),
		),
		'loginID' => array(
			array(
				'type' => 'NonSpace',
				'message' => '未入力です'
			),
			array(
				'type' => 'StringMax',
				'num' => 255,
				'message' => '全角で122文字以上で入力して下さい'
			),
		),
		'loginID' => array(
			array(
				'type' => 'NonSpace',
				'message' => '未入力です'
			),
			array(
				'type' => 'StringMax',
				'num' => 255,
				'message' => '全角で122文字以上で入力して下さい'
			),
			array(
				'type' => 'checkEmail',
				'message' => '既に登録済みです'
			),
		),
		'pass' => array(
			array(
				'type' => 'NonSpace',
				'message' => '未入力です'
			),
			array(
				'type' => 'StringMax',
				'num' => 12,
				'message' => '全角で122文字以上で入力して下さい'
			),
		),
	);
	
	function checkEmail($strCheck, $arrayError, $key){

		$this->CompanyBase->addQuery('loginID', $strCheck);


		if ($this->CompanyBase->getUID()){
			$this->CompanyBase->addQuery('id <>', $this->CompanyBase->getUID());
		}

		if ($this->CompanyBase->getData()->getData()){
			return $arrayError['message'];
		}

	}
}

?>
