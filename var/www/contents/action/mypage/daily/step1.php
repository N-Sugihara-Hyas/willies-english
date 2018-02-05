<?php
/*
*	初期設定画面
*/

		//モデル情報の読み込み
		$this->addModel(array('cource/BaseDaily'));

		$this->getCommon();
		
		$cID = getVar($this->arrayAll, 'cource_base_id');
		$level = getVar($this->arrayAll, 'level');

		

		$this->set('error', getVar($this->arrayAll, 'error') );
		$this->set('arrayCource', $this->CourceBaseDaily->getData()->getDataAll());
		$this->set('cource_base_id', $cID);
		$this->set('level', $level);

?>