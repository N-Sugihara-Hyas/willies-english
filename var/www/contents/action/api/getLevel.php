<?php

	/***********************************************************
	 * 画像の表示
	 */

		$this->addModel(array('cource/BaseDaily'));

		$this->CourceBaseDaily->addQuery('id', $this->arrayAll['data']);
		$arrayData = $this->CourceBaseDaily->getData()->getData();

		for ($i = 1; $i <= $arrayData['level']; $i++){
			echo $i . ',レベル' . $i . "\n";
		}

		exit();
?>
