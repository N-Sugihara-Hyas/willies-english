<?php

		/*
		*	JS読み込み
		*/

		header('Content-Type: text/javascript');
		echo file_get_contents($this->arrayDir['dirProgram'] . $_REQUEST['urls']);
		exit();
?>