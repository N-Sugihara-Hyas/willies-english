<?php

		/*
		*	CSS読み込み
		*/
		header('Content-Type: text/css');
		echo file_get_contents($this->arrayDir['dirProgram'] . $_REQUEST['urls']);
		exit();
?>