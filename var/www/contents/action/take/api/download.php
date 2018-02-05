<?php

	/***********************************************************
	 * 画像の表示
	 */

		$this->addModel(array('media/Image'));


		$this->MediaImage->addModelTool('Image');

		$this->MediaImage->addQuery('fileName', $this->uid);
		$arrayData = $this->MediaImage->getData()->getData();

		header('Content-Type: application/force-download');
		header('Content-disposition: attachment; filename="'.$arrayData['name'].'"');

		echo base64_decode($arrayData['body']);

		exit();
?>
