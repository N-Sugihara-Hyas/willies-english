<?php
/*
*	オリジナルカード画面
*/
		//モデル情報の読み込み
		$this->addModel(array('ext/Movie'));

		$this->getCommon();
				

		
		$arrayMovie = $this->ExtMovie->getDataUID($this->uid)->getData();

		if (!$arrayMovie){$this->setRedirect('');}

		$this->set('arrayMovie', $arrayMovie);
?>