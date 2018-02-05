<?php
	require_once 'BaseAdmin.php';

	unset($arrayColum['state']);
	unset($arrayColum['selectJob']);
	unset($arrayColum['selectSearch']);
	unset($arrayColum['memo']);
	unset($arrayColum['cource_base_id']);
	unset($arrayColum['cource_style_id']);
	unset($arrayColum['cource_schedule_id']);
	unset($arrayColum['take_base_id']);
	unset($arrayColum['stateDaily']);
	unset($arrayColum['dateChange']);
	unset($arrayColum['countLesson']);
	unset($arrayColum['countReturn']);
	unset($arrayColum['datePay']);
	unset($arrayColum['dateUnRegist']);
	unset($arrayColum['orderID1']);
	unset($arrayColum['member_base_id_adv']);
	/*
		$arrayColum['email2'] = array(
			'name' => '第二メールアドレス',
			'type' => 'text',
			'list' => '0',
			'form' => 'style="width:100%;"',
			'search ' => 0,
		);
		
	$arrayColum['email3'] = array(
		'name' => '第三メールアドレス',
		'type' => 'text',
		'list' => '0',
		'form' => 'style="width:100%;"',
		'search ' => 0,
	);
	*/
	$arrayColum['arrayMailBlock'] = array(
			'name' => '受信メール',
			'type' => 'checkbox',
			'list' => '0',
			'data' => 'AdminMailBlock',
			'controlFront' => '受信を希望するお知らせを選択してください<br />',
			'search ' => 0,
	);

	$arrayColum['nickname'] = array(
			'type' => 'text',
			'list' => '0',
			'controlFront' => '',
			'search ' => 0,
	);
	
	

	$self->parent->updateDataOut = function() use($self){
		
		$self->arrayColum['pass']['type'] = 'text';
		$self->arrayColum['passConf']['type'] = 'text';
		$self->updateDataOut2();
		
		$arrayAdminMailBlock = $self->getFunctionData('AdminMailBlock');
		$MemberMailBlock = $self->getModel('member/MailBlock');
		
		foreach ($arrayAdminMailBlock as $item){
			if (!$MemberMailBlock->getMemberType($self->arrayInput['id'], $item['id'])->getData() ){
				$self->arrayInput['arrayMailBlock'][$item['id']] = $item['id'];
				
			}
			
		}
	};

	
	$self->parent->updateData = function() use($self){
		$self->arrayMailBlock = $self->arrayData['arrayMailBlock'];
		unset($self->arrayData['arrayMailBlock']);
		
		$self->updateData2();
	};

	$self->parent->updateDataAffter = function($uid) use($self){
		$arrayAdminMailBlock = $self->getFunctionData('AdminMailBlock');
		$MemberMailBlock = $self->getModel('member/MailBlock');
		
		$MemberMailBlock->addQuery('member_base_id', $uid);
		$MemberMailBlock->delData();
		
		
		foreach ($arrayAdminMailBlock as $item){
			if (empty($self->arrayMailBlock[$item['id']])){
				$arrayData['member_base_id'] = $uid;
				$arrayData['type'] = $item['id'];

				$MemberMailBlock->commit($arrayData);		

			}
		}
	};
	

?>