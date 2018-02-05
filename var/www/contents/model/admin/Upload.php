<?php
	addModel('ModelImage');

	/*
	*	アップロード素材関連のクラス
	*/
	class AdminUpload extends ModelImage{
		var $tableName = 'admin_upload';

		var $arraySize = array(
			'default' => '200*200',
			'Thum' => '200*200',
		);

		var $defaultMime = 'image/jpeg';

	}

?>