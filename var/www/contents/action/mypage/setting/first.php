<?php
/*
*	初期設定画面
*/

		//モデル情報の読み込み
		$this->addModel(array('cource/Base', 'member/Setting'));

		$this->getCommon('first');
		
		$this->set('error', getVar($this->arrayAll, 'error') );
		$this->set('arrayCource', $this->CourceBase->getFunctionData('CourceBase'));

?>