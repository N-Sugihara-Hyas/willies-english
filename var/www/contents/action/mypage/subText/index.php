<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		$this->addModel(array('member/Base'));


		//共通処理
		$this->getCommon();
		
		//教材の情報取得
		$arrayType = $this->TeachingBase->getFunctionData('Teaching');
		foreach ($arrayType as $key => $value){
			$arrayTextBook[$value['value']] = $this->TeachingBase->getCategory($key)->getDataAll();
		}
		
		$this->set('arrayTextBook', $arrayTextBook);
			
?>