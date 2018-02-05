<?php

	addModel('ModelDB');

	/*
	*	関連のクラス
	*/
	class MediaImage extends ModelDB{
		var $tableName = 'media_image';
		var $dirImg = 'imgMedia';
		var $type = 'Upload';
		var $arraySize = array(
			'Thum' => '100x100',
		);
	}

?>