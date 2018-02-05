<?php

	/***********************************************************
	 * 画像の表示
	 */

		$this->addModel(array('media/Image'));

		ini_set('display_errors', 'Off');

		$this->getCommon();


		$this->MediaImage->addModelTool('Image');

		$this->MediaImage->addQuery('fileName', $this->uid);
		$arrayFile = $this->MediaImage->getData()->getData();

		header('content-type:' . $arrayFile['mime']);
		echo base64_decode($arrayFile['body']);

		exit();
?>
