<?php
	$arrayColum = array(
		'take_base_id' => array(
			'type' => 'hidden',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'data' => 'TakeBase',
			'form' => '',
			'search' => true,
		),
		'date' => array(
			'type' => 'hidden',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => 'style="width:10em"',
			'search' => true,
		),
		'type' => array(
			'name' => 'Type',
			'type' => 'select',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'data' => 'ReserveType',
			'form' => '',
			'search' => true,
		),
		'timeStart' => array(
			'type' => 'hidden',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'data' => 'Time',
			'form' => '',
			'search' => true,
		),
		'skypeTime' => array(
			'name' => 'Time End',
			'type' => 'select',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'data' => 'TimeEnd',
			'form' => '',
			'search' => true,
		),
		'member_base_id' => array(
			'name' => 'Students ID',
			'type' => 'text',
			'list' => '1',
			'form' => 'style="width:4em;"',
			'search' => true,
		),
		'isTrial' => array(
			'name' => 'Trial',
			'type' => 'checkbox',
			'list' => '1',
			'checkValue' => 'Trial',
		),
	);

	$self->parent->updateData = function() use($self){
		if (!$self->arrayData['member_base_id']){
			$self->arrayData['member_base_id'] = 0;
		}else{
			$MemberBase = $self->getModel('member/Base');
			$arrayMember = $MemberBase->getDataUID($self->arrayData['member_base_id'])->getData();
			$cs = $arrayMember['cource_style_id'];
		}

		if ($self->arrayData['type'] == 4){
			$cs = 0;
		}

		$self->addDataTime($self->arrayData['member_base_id'], $self->arrayData['date'], $self->arrayData['timeStart'] . ':00', $self->arrayData['skypeTime'], $cs, $self->arrayData['take_base_id'], $self->arrayData['type'], intval(getVar($self->arrayData, 'isTrial')));
	};

	$self->parent->updateDataAffter = function($uid) use($self){
	};


?>