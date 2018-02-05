<?php
/*
*	オリジナルカード画面
*/
		//モデル情報の読み込み
		$this->addModel(array('card/Base'));

		$this->getCommon();

		if ($this->arrayPost){
			if ($this->arrayPost['cardName']){
				$arrayData = $this->arrayPost;
				$arrayData['type'] = 3;
				$arrayData['state'] = 0;

				$uid = $this->CardBase->commit($arrayData);

				$this->setRedirect('card/base/?uid=' . $uid . '&cardName=' . urlencode($this->arrayPost['cardName']));
			}else{
				$this->setRedirect('card/base/?error=1');
			}
		}

		$this->set('arrayPost', $this->arrayAll);

?>