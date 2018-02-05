<?php
/*
*	オリジナルカード画面
*/
		//モデル情報の読み込み
		$this->addModel(array('test/Base'));

		$this->getCommon();

		header('content-type: text/html; charset=utf-8');

		if ($this->arrayPost){
			if ($this->arrayPost['testName']){				
				$arrayData = $this->arrayPost;
				$arrayData['state'] = 0;
				$arrayData['admin_login_id'] = $this->arrayUser['id'];


				$uid = $this->TestBase->commit($arrayData);

				$this->setRedirect('test/base/?uid=' . $uid . '&testName=' . urlencode($this->arrayPost['testName']));
			}else{
				$this->setRedirect('test/base/?error=1');
			}
		}

		$this->set('arrayPost', $this->arrayAll);

?>