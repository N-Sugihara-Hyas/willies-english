<?php

	$arrayColum = array(
		'type' => array(
			'name' => 'Select Template',
			'type' => 'select',
			'data' => 'FeedLevel',
			'list' => 0,
			'search' => 0,
			'form' => 'style="width:100%;"',
		),
		'level' => array(
			'name' => 'Level',
			'type' => 'text',
			'list' => 0,
			'search' => false,
			'form' => 'style="width:100%;"',
		),
		'feedback' => array(
			'name' => 'Feedback',
			'type' => 'textarea',
			'list' => 0,
			'search' => false,
			'form' => 'style="width:100%;height:65em;"',
		),
	);

	$self->parent->updateDataOut = function() use($self){

	};

	$self->parent->updateData = function() use($self){
		if (isset($self->isMail)){
			$self->addLiblary('mail/QdMail');
			$MemberBase = $self->getModel('member/Base');

			$MailQdMail = new MailQdMail();


			$arrayUser = $MemberBase->getDataUID($self->arrayData['member_base_id'])->getData();
			
			$MailQdMail->to(array($arrayUser['email']));
			$MailQdMail->subject($self->arrayData['subject']);
			$MailQdMail->setBody($self->arrayData['body']);
			$MailQdMail->from($self->arraySetting['from'], $self->arraySetting['title']);
			$MailQdMail->_send();

			//���[���q�X�g���[�ɂ��ۑ�
			$MasterMailLog = $self->getModel('master/MailLog');
			$MasterMailLog->addLog($arrayUser['email'], $self->arrayData['subject'], $self->arrayData['body'], $self->arrayData['member_base_id']);
		}else{
			$self->arrayData['member_base_id'] = $self->getSession('mID');
			$self->arrayData['take_base_id'] = $self->arrayUser['id'];

			$self->addModelTool('Mail');

			//���[�U�[���擾
			$MemberBase = $self->getModel('member/Base');
			$arrayMember = $MemberBase->getDataUID($self->arrayData['member_base_id'])->getData();
			
			//���x���̓��͂�����΍X�V��
			if ($self->arrayData['level']){
				$arrayMember['level'] = $self->arrayData['level'];
				$MemberBase->commit($arrayMember);
			}

			$self->arrayMail = $arrayMember;
			$self->arrayMail['memberName'] = $arrayMember['memberNameSecound'] . ' ' . $arrayMember['memberNameFirst'];


			//���͂����u�t���擾
			$TakeBase = $self->getModel('take/Base');
			$arrayTake = $TakeBase->getDataUID($self->arrayData['take_base_id'])->getData();
			
			$self->arrayMail = array_merge($self->arrayMail, $arrayTake);
			$self->arrayMail = array_merge($self->arrayMail, $self->arrayData);


			//�S���u�t���擾
			$TakeBase = $self->getModel('take/Base');
			$arrayTake = $TakeBase->getDataUID($arrayMember['take_base_id'])->getData();
			
			$self->arrayMail['nickname2'] = $arrayTake['nickname'];

			//���[������
			$arrayMailList = array('', 36, 38, 37, 39, 40, 41);
			$mailType = $arrayMailList[$self->arrayData['type']];

			$AdminMail = $self->getModel('admin/Mail');
			$arrayMail = $AdminMail->getDataUID($mailType)->getData();

			foreach ($self->arrayMail as $key => $item){
				$arrayMail['body'] = str_replace('({$' . $key . '})', $item, $arrayMail['body']);
				$arrayMail['subject'] = str_replace('({$' . $key . '})', $item, $arrayMail['subject']);
			}

			$self->arrayData['subject'] = $arrayMail['subject'];
			$self->arrayData['body'] = $arrayMail['body'];


			unset($self->arrayData['tempate']);
		}

	};


?>