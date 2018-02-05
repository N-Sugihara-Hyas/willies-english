<?php
	$arrayColum = array(
		'subject' => array(
			'name' => 'Subject',
			'type' => 'text',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => 'style="width:100%;"',
			'search' => true,
		),
		'message' => array(
			'name' => 'Message',
			'type' => 'textarea',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => 'style="width:100%;height:40em;"',
			'search' => true,
		),
	);

	$self->parent->updateDataOut = function() use($self){
		$self->arrayInput['message'] = str_replace("Textbook Level for trial lesson:  5", 'Textbook Level for trial lesson:  1', $self->arrayInput['message']);
	};
	
	$self->parent->updateData = function() use($self){
		$self->arrayData['from_id'] = $self->arrayUser['id'];

		$res = $self->getSession('res');

		if ($res){
			$self->arrayData['to_id'] = $self->getSession('res');
		}else{
			$self->arrayData['to_id'] = -1;
		}
	};


?>