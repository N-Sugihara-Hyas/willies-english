<?php

	addModel('ModelDB');

	/*
	*	ページ関連のクラス
	*/
	class AdminPage extends ModelDB{
	var $tableName = 'admin_page';

		function getDataPage($page){
			$this->addQuery('url', $page);
			
			return $this->getData()->getData();
		}
	}

?>