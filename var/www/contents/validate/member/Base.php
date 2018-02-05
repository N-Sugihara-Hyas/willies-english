<?php

class ValidateMemberBase extends Validate{
	var $validate = array(
		'memberNameSecound' => array(
			array(
				'type' => 'NonSpace',
				'message' => '姓が未入力です'
			),
			array(
				'type' => 'StringMax',
				'num' => 255,
				'message' => '姓は全角122文字以内で入力して下さい'
			),
		),
		'memberNameFirst' => array(
			array(
				'type' => 'NonSpace',
				'message' => '名が未入力です'
			),
			array(
				'type' => 'StringMax',
				'num' => 255,
				'message' => '名は全角122文字以内で入力して下さい'
			),
		),
		'memberNameSecoundEnglish' => array(
			array(
				'type' => 'NonSpace',
				'message' => '姓が未入力です'
			),
			array(
				'type' => 'English',
				'message' => '姓は半角英数字で入力して下さい'
			),
			array(
				'type' => 'StringMax',
				'num' => 255,
				'message' => '姓は半角255文字以内で入力して下さい'
			),
		),
		'memberNameFirstEnglish' => array(
			array(
				'type' => 'NonSpace',
				'message' => '名が未入力です'
			),
			array(
				'type' => 'English',
				'message' => '名は半角英数字で入力して下さい'
			),
			array(
				'type' => 'StringMax',
				'num' => 255,
				'message' => '名は半角255文字以内で入力して下さい'
			),
		),
		'email' => array(
			array(
				'type' => 'NonSpace',
				'message' => '未入力です'
			),
			array(
				'type' => 'Mail',
				'message' => 'メールアドレス形式で入力して下さい'
			),
			array(
				'type' => 'StringMax',
				'num' => 255,
				'message' => 'メールアドレスは半角255文字以内で入力して下さい'
			),
			array(
				'type' => 'Conf',
				'conf' => 'emailConf',
				'message' => 'メールアドレス(確認用)と同じものを入れてください'
			),
			array(
				'type' => 'checkEmail',
				'message' => '既に登録済みです'
			),

		),
		'tel1' => array(
			array(
				'type' => 'NonSpace',
				'message' => '電話番号1が未入力です'
			),
			array(
				'type' => 'Number',
				'num' => 4,
				'message' => '電話番号1は半角数字で入力して下さい'
			),
			array(
				'type' => 'StringMax',
				'num' => 4,
				'message' => '電話番号1は半角4文字以内で入力して下さい'
			),
		),
		'tel2' => array(
			array(
				'type' => 'NonSpace',
				'message' => '電話番号2が未入力です'
			),
			array(
				'type' => 'Number',
				'num' => 4,
				'message' => '電話番号2は半角数字で入力して下さい'
			),
			array(
				'type' => 'StringMax',
				'num' => 4,
				'message' => '電話番号2は半角4文字以内で入力して下さい'
			),
		),
		'tel3' => array(
			array(
				'type' => 'NonSpace',
				'message' => '電話番号3が未入力です'
			),
			array(
				'type' => 'Number',
				'num' => 4,
				'message' => '電話番号3は半角数字で入力して下さい'
			),
			array(
				'type' => 'StringMax',
				'num' => 4,
				'message' => '電話番号3は半角4文字以内で入力して下さい'
			),
		),

		'skypeID' => array(
			array(
				'type' => 'NonSpace',
				'message' => '未入力です'
			),
			array(
				'type' => 'StringMax',
				'num' => 255,
				'message' => '半角英数字で255文字以内で入力して下さい'
			),
			array(
				'type' => 'English',
				'message' => '半角英数字で入力して下さい'
			),
		),
		'zip1' => array(
			array(
				'type' => 'NonSpace',
				'message' => '郵便番号の左側が未入力です'
			),
			array(
				'type' => 'Number',
				'message' => '郵便番号の左側は半角数字で入力して下さい'
			),
			array(
				'type' => 'StringMax',
				'num' => 3,
				'message' => '郵便番号の左側は半角3文字以内で入力して下さい'
			),
		),
		'zip2' => array(
			array(
				'type' => 'NonSpace',
				'message' => '郵便番号の右側が未入力です'
			),
			array(
				'type' => 'Number',
				'message' => '郵便番号の右側は半角数字で入力して下さい'
			),
			array(
				'type' => 'StringMax',
				'num' => 4,
				'message' => '郵便番号の右側は半角4文字以内で入力して下さい'
			),
		),
		'setting_area2_id' => array(
			array(
				'type' => 'NonSpace',
				'message' => '都道府県が未選択です'
			),
		),
		'level' => array(
			array(
				'type' => 'StringMax',
				'num' => 2000,
				'message' => '全角で1000文字以内で入力して下さい'
			),
		),
		'keywordSearch' => array(
			array(
				'type' => 'StringMax',
				'num' => 200,
				'message' => '全角で100文字以内で入力して下さい'
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
				'message' => 'パスワードは半角12文字以内で入力して下さい'
			),
			array(
				'type' => 'StringMin',
				'num' => 6,
				'message' => 'パスワードは半角6文字以上で入力して下さい'
			),
			array(
				'type' => 'English',
				'message' => 'パスワードは半角英数字で入力して下さい'
			),
			array(
				'type' => 'English',
				'message' => 'パスワードは半角英数字で入力して下さい'
			),
			array(
				'type' => 'Conf',
				'conf' => 'passConf',
				'message' => 'パスワードと確認用は同じものを入力して下さい'
			),
		),
		'selectSearch' => array(
			array(
				'type' => 'CheckSearch',
				'message' => '未選択です'
			),
		),
	);

	function checkEmail($strCheck, $arrayError, $key){

		$this->MemberBase->addQuery('email', $strCheck);


		if ($this->MemberBase->getUID()){
			$this->MemberBase->addQuery('id <>', $this->MemberBase->getUID());
		}

		if ($this->MemberBase->getData()->getData()){
			return $arrayError['message'];
		}

	}

	function CheckSearch($strCheck, $arrayError, $key){
		if (!$strCheck){
			return $arrayError['message'];
		}
	}

}

?>
