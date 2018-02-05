<?php
/*
*	オリジナルカード画面
*/
		//モデル情報の読み込み
		$this->addModel(array('test/Details'));

		$this->getCommon();

		$did = $this->arrayAll['did'];

		//現問題の取得
		$arrayDetails = $this->TestDetails->getDataUID($did)->getData();

		if (!empty($this->arrayAll['sub1'])){
			$arrayAnser = $this->TestDetails->getAnser();

			//正解か不正解か？
			if ($this->arrayAll['select'] == $arrayDetails['hit']){
				$arrayAnser[$did]['isOK'] = 1;
			}else{
				$arrayAnser[$did]['isOK'] = 0;
			}
			$arrayAnser[$did]['select'] = $this->arrayAll['select'];
			$arrayAnser[$did]['date'] = date('m/d');

			$this->TestDetails->setAnser($arrayAnser);

			if (empty($this->arrayAll['next'])){
				//問題が無い場合は終了へ
				$this->setRedirect('card/test/end/');
			}else{
				$this->setRedirect('card/test/details/?did=' . $this->arrayAll['next'] . '&ng=' . getVar($this->arrayAll, 'ng'));
			}
		}else{
			unset($arrayAnser[$did]['isOK']);

			$this->setRedirect('card/test/details/?did=' . $this->arrayAll['back'] . '&ng=' . getVar($this->arrayAll, 'ng'));
		}


?>