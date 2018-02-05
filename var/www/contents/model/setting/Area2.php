<?php

	addModel('ModelDB');

	/*
	*	都道府県関連のクラス
	*/
	class SettingArea2 extends ModelDB{
	var $tableName = 'setting_area2';
	var $order = 'id ASC';
	
		/*
		 * SEO対策用のIDからDB上のIDに変換
		 * @params $sID SEOのID
		 * @return DB上のID
		 */
		function changeID($sID){
			$aID2 = str_replace('a', '', $sID);
			
			return $aID2;
		}
		
		/*
		 * 地域から取得
		 * @params $aID 地域
		 * @return 都道府県データ
		 */
		function getArea($aID){
			$this->addQuery('setting_area_id', $aID);
			
			return $this->getdata();
		}
	}

?>