<?php

	/***********************************************************
	 * 画像の表示
	 */

		$this->addModel(array('media/Image'));

		$this->MediaImage->default = $this->arrayDir['dirView'] . '/common_admin/img/noImage.gif';
		$this->MediaImage->fileName = $this->arrayDir['dirView'] . 'tmp/imgMedia/' . $this->uid;
		$this->MediaImage->noImage = $this->arrayDir['dirView'] . 'common/img/noImage.gif';

		$this->MediaImage->addModelTool('Image');

		if (isset($this->arrayAll['cID'])){
			$this->MediaImage->addModelTool('Upload');
			$arrayUpload = $this->MediaImage->uploadGetSession($this->arrayAll['cID']);

			$this->MediaImage->viewResizeBinary('Thum', getVar($arrayUpload, 'body'));
		}else{
			$size = getVar($this->arrayParams, 1);

			if ($size){
				$this->MediaImage->viewReSize($size);
			}else{
				$this->MediaImage->view();
			}
		}

		exit();
?>
