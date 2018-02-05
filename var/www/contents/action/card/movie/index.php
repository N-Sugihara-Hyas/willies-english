<?php
/*
*	オリジナルカード画面
*/
		//モデル情報の読み込み
		$this->addModel(array('ext/Movie'));

		$this->getCommon();
		
		$this->ExtMovie->addQuery('(0');
		$this->ExtMovie->addQuery('OR cource_base_id LIKE', '%' . $this->arrayUser['cource_base_id'] . ',%');
		$this->ExtMovie->addQuery('OR 0)');
		
		$this->ExtMovie->addQuery('AND (0');
		$this->ExtMovie->addQuery('OR type LIKE', '%' . $this->arrayUser['state'] . ',%');
		$this->ExtMovie->addQuery('OR 0)');

		$this->ExtMovie->addQuery('AND (0');
		$this->ExtMovie->addQuery('OR levelRLC LIKE', '%' . $this->arrayUser['levelRLC'] . ',%');
		$this->ExtMovie->addQuery('OR levelRLC IS NULL');
		$this->ExtMovie->addQuery('OR levelRLC', ' ');
		$this->ExtMovie->addQuery('OR 0)');

		$this->ExtMovie->addQuery('AND (0');
		$this->ExtMovie->addQuery('OR levelGCC LIKE', '%' . $this->arrayUser['levelGCC'] . ',%');
		$this->ExtMovie->addQuery('OR levelGCC IS NULL');
		$this->ExtMovie->addQuery('OR levelGCC', ' ');
		$this->ExtMovie->addQuery('OR 0)');				

		$this->ExtMovie->addQuery('AND (0');
		$this->ExtMovie->addQuery('OR levelChild LIKE', '%' . $this->arrayUser['levelChild'] . ',%');
		$this->ExtMovie->addQuery('OR levelChild IS NULL');
		$this->ExtMovie->addQuery('OR levelChild', ' ');
		$this->ExtMovie->addQuery('OR 0)');				


		$keyword = getVar($this->arrayAll, 'keyword');
		
		if ($keyword){
				$this->ExtMovie->addQuery('(0');
				$this->ExtMovie->addQuery('OR movieName LIKE', '%' . $keyword . '%');
				$this->ExtMovie->addQuery('OR comment LIKE', '%' . $keyword . '%');
				$this->ExtMovie->addQuery('1)');				
		}
		
		$arrayMovie = $this->ExtMovie->getData()->getDataAll();
		
		$this->set('keyword', $keyword);
		$this->set('arrayMovie', $arrayMovie);
?>