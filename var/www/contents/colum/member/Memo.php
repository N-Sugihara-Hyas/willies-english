<?php

	$arrayColum = array(
		'member_memo_category_id' => array(
			'name' => 'カテゴリ',
			'type' => 'select',
			'list' => '1',
			'search' => false,
			'labelBack' => '<span class="attBox">*</span>',
			//'controlBack' => '<br /><a href="/mypage/memoCategory/edit/">カテゴリを新たに作成する</a><br /><a href="/mypage/memoCategory/del/">カテゴリを削除する</a>',
			'data' => 'MemberMemoCategory',
			'form' => 'style="width:70%;"',
		),
		'body' => array(
			'name' => 'メモの内容',
			'type' => 'textarea',
			'list' => '0',
			'search' => false,
			'labelBack' => '<span class="attBox">*</span>',
			'form' => 'style="width:70%;height:6em;"',
		),
	);
	
	$self->parent->updateData = function() use($self){
		$self->arrayData['member_base_id'] = $self->arrayUser['id'];
	};


?>