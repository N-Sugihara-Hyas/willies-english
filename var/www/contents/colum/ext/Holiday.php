<?php

	$arrayColum = array(
		'date' => array(
			'name' => '休日(日付)',
			'type' => 'cal',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => 'style="width:10em;"',
			'search' => true,
		),
		'timeStart' => array(
			'name' => '休日(開始時間)',
			'type' => 'select',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'data' => 'Time',
			'form' => '',
			'search' => false,
		),
		'timeEnd' => array(
			'name' => '休日(終了時間)',
			'type' => 'select',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'data' => 'Time',
			'form' => '',
			'search' => false,
		),
		'comment' => array(
			'name' => 'コメント',
			'type' => 'text',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => 'style="width:30em;"',
			'search' => true,
		),

	);

	$self->parent->updateDataOut = function() use($self){
		list ($self->arrayInput['date'], $self->arrayInput['timeStart']) = explode(' ', substr($self->arrayInput['dateStart'], 0, strlen($self->arrayInput['dateStart']) - 3));
		list ($self->arrayInput['date'], $self->arrayInput['timeEnd']) = explode(' ', substr($self->arrayInput['dateEnd'], 0, strlen($self->arrayInput['dateEnd']) - 3));
				

	};

	$self->parent->updateData = function() use($self){
		$self->arrayData['dateStart'] = $self->arrayData['date'] . ' ' . $self->arrayData['timeStart'] . ':00';
		$self->arrayData['dateEnd'] = $self->arrayData['date'] . ' ' . $self->arrayData['timeEnd'] . ':00';
		
		unset($self->arrayData['date']);
		unset($self->arrayData['timeStart']);
		unset($self->arrayData['timeEnd']);
	};


?>