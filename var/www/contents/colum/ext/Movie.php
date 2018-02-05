<?php

	$arrayColum = array(
		'sort' => array(
			'name' => '表示順(小さい数字ほど上に)',
			'type' => 'text',
			'list' => '1',
			'search' => false,
			'form' => '',
		),
		'movieName' => array(
			'name' => '動画の名称',
			'type' => 'text',
			'list' => '1',
			'form' => 'style="width:100%;"',
			'search' => true,
		),
		'comment' => array(
			'name' => '動画のコメント',
			'type' => 'textarea',
			'list' => '0',
			'form' => 'style="width:100%;height:20em;"',
			'search' => true,
		),
		'url' => array(
			'name' => 'URL',
			'type' => 'text',
			'list' => '1',
			'form' => 'style="width:100%;"',
			'search' => true,
		),
		'type' => array(
			'name' => '生徒ステータス',
			'type' => 'checkbox',
			'data' => 'MemberState',
			'dataType' => 'key',
			'list' => '1',
			'search' => false,
		),
		'cource_base_id' => array(
			'name' => 'コース',
			'type' => 'checkbox',
			'data' => 'CourceBase',
			'list' => '1',
			'search' => true,
		),
		'levelRLC' => array(
			'name' => 'レベル(RLC)',
			'type' => 'checkbox',
			'data' => 'Level',
			'list' => '1',
			'search' => false,
		),
		'levelGCC' => array(
			'name' => 'レベル(GCC)',
			'type' => 'checkbox',
			'data' => 'Level',
			'list' => '1',
			'search' => false,
		),
		'levelChild' => array(
			'name' => 'レベル(子供)',
			'type' => 'checkbox',
			'data' => 'Level',
			'list' => '1',
			'search' => false,
		),
	);

	$this->parent->updateDataOut = function() use($self){
		$arrayType = explode(',', $self->arrayInput['type']);		
		foreach ($arrayType as $item){
			$arrayType2[$item] = 1;
		}
		$self->arrayInput['type'] = $arrayType2;

		$arrayCID = explode(',', $self->arrayInput['cource_base_id']);		
		foreach ($arrayCID as $item){
			$arrayCID2[$item] = $item;
		}
		$self->arrayInput['cource_base_id'] = $arrayCID2;
		
		$arrayCID = explode(',', $self->arrayInput['levelRLC']);		
		$arrayCID2 = array();

		foreach ($arrayCID as $item){
			$arrayCID2[$item] = $item;
		}
		$self->arrayInput['levelRLC'] = $arrayCID2;

		$arrayCID = explode(',', $self->arrayInput['levelGCC']);		
		$arrayCID2 = array();
		foreach ($arrayCID as $item){
			$arrayCID2[$item] = $item;
		}
		$self->arrayInput['levelGCC'] = $arrayCID2;

		$arrayCID = explode(',', $self->arrayInput['levelChild']);		
		$arrayCID2 = array();
		foreach ($arrayCID as $item){
			$arrayCID2[$item] = $item;
		}
		$self->arrayInput['levelChild'] = $arrayCID2;


	};

	$this->parent->updateData = function() use($self){
		$type = '';
		foreach ($self->arrayData['type'] as $item){
			$type.= $item . ',';
		}						
		$self->arrayData['type'] = $type;		


		$cid = '';
		foreach ($self->arrayData['cource_base_id'] as $item){
			$cid.= $item . ',';
		}						
		
		$self->arrayData['cource_base_id'] = $cid;		


		$cid = '';
		foreach ($self->arrayData['levelRLC'] as $item){
			$cid.= $item . ',';
		}						
		$self->arrayData['levelRLC'] = $cid;		

		$cid = '';
		foreach ($self->arrayData['levelGCC'] as $item){
			$cid.= $item . ',';
		}						
		$self->arrayData['levelGCC'] = $cid;		

		$cid = '';
		foreach ($self->arrayData['levelChild'] as $item){
			$cid.= $item . ',';
		}						
		$self->arrayData['levelChild'] = $cid;		

	};


?>