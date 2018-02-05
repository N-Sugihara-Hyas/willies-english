<?php

	$arrayColum = array(
		'memberNameSecound' => array(
			'name' => '名前（漢字）',
			'type' => 'text',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'controlFront' => '姓',
			'form' => 'style="width:10em;"',
			'search' => 0,
		),
		'memberNameFirst' => array(
			'type' => 'text',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'controlFront' => '&nbsp;名',
			'form' => 'style="width:10em;"',
			'search' => 0,
		),
		'memberNameSecoundEnglish' => array(
			'name' => '名前（アルファベット）',
			'type' => 'text',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'controlFront' => '姓',
			'form' => 'style="width:10em;"',
			'search ' => 1,
		),
		'memberNameFirstEnglish' => array(
			'type' => 'text',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'controlFront' => '&nbsp;名',
			'form' => 'style="width:10em;"',
			'search ' => 1,
		),
		'email' => array(
			'name' => 'メールアドレス',
			'type' => 'text',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'controlBack' => '<br />※PC用アドレスのみとなります。常時使うメールアドレスをご使用下さい<br />※生徒様マイページのログインIDとして使用します。',
			'form' => 'style="width:100%;"',
			'search ' => 1,
		),
		'emailConf' => array(
			'name' => 'メールアドレス(確認用)',
			'type' => 'text',
			'list' => '0',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => 'style="width:100%;"',
			'search ' => 0,
		),


		'pass' => array(
			'name' => 'ログインパスワード <br />（6文字以上半角英数で入力下さい）',
			'type' => 'password',
			'list' => '0',
			'labelBack' => '<span class="attBox">*</span>',
			'controlBackFirst' => '<br />※生徒様マイページのログインパスワードとして使用しますので忘れないよう保管して下さい<br />※半角英数で６文字以上で設定下さい',
			'form' => 'style="width:70%;"',
		),
		'passConf' => array(
			'name' => 'ログインパスワード(確認用)',
			'type' => 'password',
			'list' => '0',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => 'style="width:70%;"',
		),
		'tel1' => array(
			'name' => '電話番号',
			'type' => 'text',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'controlBack' => '-',
			'form' => 'style="width:4em;"',
			'search ' => 0,
		),
		'tel2' => array(
			'type' => 'text',
			'list' => '1',
			'controlBack' => '-',
			'form' => 'style="width:4em;"',
			'search ' => 0,
		),
		'tel3' => array(
			'type' => 'text',
			'list' => '1',
			'form' => 'style="width:4em;"',
			'search ' => 0,
		),
		'skypeID' => array(
			'name' => 'スカイプ名（英数と記号）',
			'type' => 'text',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => 'style="width:10em;"',
			'search ' => 0,
		),
		'zip1' => array(
			'name' => '住所',
			'type' => 'text',
			'labelBack' => '<span class="attBox">*</span>',
			'controlFront' => '・郵便番号<br />',
			'list' => '1',
			'form' => 'style="width:3em;"',
			'search ' => 0,
		),
		'zip2' => array(
			'type' => 'text',
			'controlFront' => '-',
			'list' => '1',
			'form' => 'style="width:4em;"',
			'search ' => 0,
		),
		'setting_area2_id' => array(
			'type' => 'select',
			'controlFront' => '<br />・都道府県<br />',
			'list' => '1',
			'data' => 'Area2',
			'search ' => 0,
		),
		'selectJob' => array(
			'name' => '職業',
			'type' => 'select',
			'list' => '1',
			'data' => 'Job',
			'search ' => 0,
		),
		'member_base_id_adv' => array(
			'name' => '紹介者の会員ID',
			'type' => 'text',
			'list' => '0',
			'controlBack' => '<p><a href="http://williesenglish.jp/campaign.html" target="_blank">※当スクールをご紹介して頂いた既存会員様のIDを入力下さい。詳しくはこちら>></a></p>',
			'form' => '',
			'search ' => 0,
		),
		'levelComment' => array(
			'name' => '現在の英語レベル',
			'type' => 'textarea',
			'list' => '1',
			'form' => 'style="width:70%;height:10em;"',
			'controlBackFirst' => '<br />（例）TOEICスコアや苦手意識などご記入下さい。',
			'search ' => 0,
		),		
		'dream' => array(
			'name' => '今後の目標',
			'type' => 'textarea',
			'list' => '1',
			'form' => 'style="width:70%;height:10em;"',
			'controlBackFirst' => '<br />（例）受験や英会話で目指すレベル、目標などご記入下さい。',
			'search ' => 0,
		),
		'selectSearch' => array(
			'name' => 'どこで当サイトを知りましたか？',
			'type' => 'select',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'data' => 'Search',
			'search ' => 0,
		),
		'keywordSearch' => array(
			'name' => '上記について詳細を教えて下さい',
			'type' => 'textarea',
			'list' => '1',
			'controlBackFirst' => '<br />例）ネット比較サイトの名前<br />例）検索された際のキーワード（オンライン英会話, 担任制 など）<br />例）口コミサイトの名前　など',
			'search ' => 0,
		),
		'acting' => array(
			'name' => '代講希望の有無',
			'type' => 'radio',
			'list' => '0',
			'data' => 'Acting',
			'controlFront' => '<p>ご予約された講師が病気などで突然お休みを頂いた際、当該レッスンは代講をご希望されますか？<br />それとも振替レッスンポイントをご希望されますか？<br /><br />',
			'search ' => 0,
			'default' => 1,
		),
	);

	$self->parent->updateData = function() use($self){
		unset($self->arrayData['emailConf']);

		$self->arrayData['tel'] = $self->arrayData['tel1'] . '-' . $self->arrayData['tel2'] . '-' . $self->arrayData['tel3'];
		unset($self->arrayData['tel1']);
		unset($self->arrayData['tel2']);
		unset($self->arrayData['tel3']);

		$self->arrayData['zip'] = $self->arrayData['zip1'] . '-' . $self->arrayData['zip2'];

		unset($self->arrayData['zip1']);
		unset($self->arrayData['zip2']);

		//新規登録時は一時IDを付加
		if (!$self->getUID()){
			$self->addLiblary('inoutput/String');
			$self->arrayData['sid'] = InoutputString::getRandomString(32);
		}

		$self->arrayData['pass'] = $self->getPassword($self->arrayData['pass']);
		unset($self->arrayData['passConf']);
		
		if (empty($self->arrayData['member_base_id_adv'])){$self->arrayData['member_base_id_adv'] = NULL;}

	};

	$self->parent->updateDataOut = function() use($self){
		$self->arrayInput['emailConf'] = $self->arrayInput['email'];
		list($self->arrayInput['tel1'], $self->arrayInput['tel2'], $self->arrayInput['tel3']) = explode('-', $self->arrayInput['tel']);
		list($self->arrayInput['zip1'], $self->arrayInput['zip2']) = explode('-', $self->arrayInput['zip']);

		$self->addLiblary('securty/Code');

		$SecurtyCode = new SecurtyCode($self->arraySetting['secretKey']);
		$self->arrayInput['passConf'] = $self->arrayInput['pass'] = $SecurtyCode->getDecode($self->arrayInput['pass']);

	};
?>