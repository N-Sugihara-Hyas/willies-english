<?php
	$arrayColum = array(
		'modified' => array(
			'name' => 'Date',
			'type' => 'text',
			'list' => '1',
			'form' => '',
		),
		'cource_base_id' => array(
			'name' => 'Category',
			'type' => 'radio',
			'list' => '1',
			'data' => 'CourceBaseAll',
			'search' => true,
			'default' => 0,
		),
		'test_type_id' => array(
			'name' => 'Type',
			'type' => 'radio',
			'list' => '1',
			'data' => 'TestType',
			'search' => true,
			'default' => 1,
		),
		'feeType' => array(
			'name' => 'Fee',
			'type' => 'radio',
			'list' => '1',
			'data' => 'Fee',
			'search' => true,
			'default' => 1,
		),
		'fee' => array(
			'type' => 'text',
			'list' => '1',
			'form' => 'style="width:6em;"',
			'controlBack' => '円（税別）',
			'search' => true,
		),
		'test_base_id' => array(
			'name' => 'Test Title',
			'type' => 'select',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'controlBackFirst' => '<a href="javascript:newBase()">New Test</a>',
			'data' => 'TestBase',
			'form' => '',
			'search' => true,
		),
		'body1' => array(
			'name' => 'Question',
			'type' => 'textarea',
			'list' => '1',
			'labelBack' => '<span class="attBox">*</span>',
			'form' => 'style="width:100%; height:10em;"',
			'search' => true,
		),
		'select1' => array(
			'name' => 'Select1',
			'type' => 'text',
			'list' => '0',
			'form' => 'style="width:100%;"',
			'search' => false,
		),
		'select2' => array(
			'name' => 'Select2',
			'type' => 'text',
			'list' => '0',
			'form' => 'style="width:100%;"',
			'search' => false,
		),
		'select3' => array(
			'name' => 'Select3',
			'type' => 'text',
			'list' => '0',
			'form' => 'style="width:100%;"',
			'search' => false,
		),
		'select4' => array(
			'name' => 'Select4',
			'type' => 'text',
			'list' => '0',
			'form' => 'style="width:100%;"',
			'search' => false,
		),
		'hit' => array(
			'name' => 'Hit Number(1-4)',
			'type' => 'text',
			'list' => '0',
			'form' => '',
			'search' => false,
		),
		'url' => array(
			'name' => 'Link',
			'type' => 'text',
			'list' => '0',
			'form' => 'style="width:100%;"',
			'search' => true,
		),
		'img1' => array(
			'name' => 'Upload',
			'type' => 'file',
			'list' => '0',
			'search' => true,
		),
		'body2' => array(
			'name' => 'Answer',
			'labelBack' => '<span class="attBox">*</span>',
			'type' => 'textarea',
			'list' => '1',
			'form' => 'style="width:100%; height:10em;"',
			'search' => true,
		),
	);

	$self->parent->updateDataOut = function() use($self){
	};

	$self->parent->updateData = function() use($self){

	};

	$self->parent->updateDataAffter = function($uid) use($self){
	};


?>