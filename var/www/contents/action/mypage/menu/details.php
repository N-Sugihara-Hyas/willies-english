<?php
/*
*	ログイン画面
*/

		//モデル情報の読み込み
		$this->addModel(array('member/Menu', 'media/Image'));
		$this->getCommon();


		$arrayFile = $this->MemberMenu->getDataUID($this->uid)->getData();

		for ($i = 1; $i <= 5; $i++){
			if ($arrayFile['fileName' . $i]){
				$this->MediaImage->addQuery('fileName', $arrayFile['fileName' . $i]);
				$arrayFile['fileNameLabel' . $i] = $this->MediaImage->getData()->getData();
			}

		}

		$this->set('arrayData', $arrayFile);

?>