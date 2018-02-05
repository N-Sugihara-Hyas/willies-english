<?php
	require_once 'Base.php';

	$arrayColumAdmin = array(
		'email2' => array(
			'name' => '第二メールアドレス',
			'type' => 'text',
			'list' => '0',
			'form' => 'style="width:100%;"',
			'search ' => 0,
		),
		'email3' => array(
			'name' => '第三メールアドレス',
			'type' => 'text',
			'list' => '0',
			'form' => 'style="width:100%;"',
			'search ' => 0,
		),		
		'cource_base_id' => array(
			'name' => '受講コース',
			'type' => 'select',
			'list' => '0',
			'data' => 'CourceBase',
			'form' => '',
			'search' => 1,
		),
		'cource_style_id' => array(
			'name' => '受講プラン',
			'type' => 'select',
			'list' => '0',
			'data' => 'CourceStyle',
			'form' => '',
			'search' => 1,
		),
		'cource_schedule_id' => array(
			'name' => '受講スケジュール',
			'type' => 'select',
			'list' => '0',
			'data' => 'Schedule',
			'form' => '',
			'search' => 1,
		),		
		'state' => array(
			'name' => '"Regular Lesson Student Status',
			'type' => 'select',
			'list' => '0',
			'data' => 'MemberState',
			'search' => 1,
		),
		'stateDaily' => array(
			'name' => 'Group Read Aloud Lesson Status',
			'type' => 'select',
			'list' => '0',
			'data' => 'MemberStateDaily',
			'search' => 1,
		),
		'pass' => array(
			'name' => 'パスワード',
			'type' => 'password',
			'list' => '0',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => 'style="width:70%;"',
		),
		'passConf' => array(
			'name' => 'パスワード(確認用)',
			'type' => 'password',
			'list' => '0',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => 'style="width:70%;"',
		),
/*		'cource_base_id' => array(
			'name' => '受講コース',
			'type' => 'select',
			'list' => '0',
			'data' => 'CourceBase',
			'form' => '',
			'search' => 1,
		),
		'cource_style_id' => array(
			'name' => '受講プラン',
			'type' => 'select',
			'list' => '0',
			'data' => 'CourceStyle',
			'form' => '',
			'search' => 1,
		),
		'cource_schedule_id' => array(
			'name' => '受講スケジュール',
			'type' => 'select',
			'list' => '0',
			'data' => 'Schedule',
			'form' => '',
			'search' => 1,
		),*/
		'countLesson' => array(
			'name' => 'レッスンポイント',
			'type' => 'text',
			'list' => '0',
			'search' => 0,
			'form' => '',
		),
		'countReturn' => array(
			'name' => '振替ポイント',
			'type' => 'text',
			'list' => '0',
			'search' => 0,
			'form' => '',
			'form' => '',
		),

		'dateChange' => array(
			'name' => '変更月',
			'type' => 'text',
			'list' => '0',
			'search' => 0,
			'form' => '',
		),
		'datePay' => array(
			'name' => '支払月日',
			'type' => 'cal',
			'list' => '0',
			'search' => 0,
			'form' => '',
		),
		'dateUnRegist' => array(
			'name' => '退会予定日',
			'type' => 'text',
			'list' => '0',
			'search' => 0,
			'form' => '',
		),
		'memo' => array(
			'name' => '管理者用自由記述エリア',
			'type' => 'textarea',
			'list' => '0',
			'form' => 'style="width:90%; height:6em;"',
			'search' => 0,
		),
		'orderID1' => array(
			'name' => '支払いのID',
			'type' => 'text',
			'list' => '0',
			'form' => 'style="width:60%;"',
			'search' => 0,
		),
	);

	$arrayColum = array_merge($arrayColum, $arrayColumAdmin);

	$self->parent->updateData2 = $self->parent->updateData;
	$self->parent->updateDataOut2 = $self->parent->updateDataOut;

	$self->parent->updateData = function() use($self){
		$self->addLiblary('securty/Code');

		/*$SecurtyCode = new SecurtyCode($self->arraySetting['secretKey']);
		$self->arrayData['pass'] = $SecurtyCode->getEncode($self->arrayData['pass']);*/
		$self->arrayData['isLogin'] = 1;

		$self->updateData2();

		unset($self->arrayData['passConf']);

		if ($self->arrayData['id']){
			//レギュラーステータスの変更
			$self->arrayData = $self->setStatus($self->arrayData);

			//グループレッスンのステータスの変更
			$self->arrayData = $self->setStatusDaily($self->arrayData);
		}



		$self->arrayDataIti = $self->arrayData;
	};

	$self->parent->updateDataOut = function() use($self){
		$self->addLiblary('securty/Code');

		/*$SecurtyCode = new SecurtyCode($self->arraySetting['secretKey']);
		$self->arrayInput['passConf'] = $self->arrayInput['pass'] = $SecurtyCode->getDecode($self->arrayInput['pass']);
		*/

		$self->updateDataOut2();

	};

?>