<?php

	addModel('ModelDB');

	/***********************************************************
	*	管理画面の設定関連のクラス
	*/
	class AdminSetting extends ModelDB{
	var $tableName = 'admin_setting';
	var $order = 'id ASC';
	var $arrayColum = array(
		'title' => array(
			'name' => '設定名',
			'type'		=> 'text',
			'list'	=> 1
		),
		'keyID' => array(
			'name' => 'キー',
			'type'	=> 'text',
			'list'	=> 1
		),

		'value' => array(
			'name' => '内容',
			'type'		=> 'textarea',
			'form'			=> 'cols="50" rows="5"',
			'list'	=> 0
		),
	);


	/*
	 * keyIDで値を取得
	 * @params $key キー　$type 取得タイプ
	 * @return 取得データ
	 */
	function getDataKey($key, $type='list'){
		$this->addQuery('keyID', $key);
		$arraySetting = $this->getData($type);

		return $arraySetting;
	}

	/*
	 * keyIDでプルダウン方式で値を取得
	* @params $key キー
	* @return 取得データ
	*/
	function getSelectKey($key){
		$this->target = 'value as id,title as value';
		$arrayData = $this->getDataKey($key);

		return $arrayData;
	}

	/*
	*	更新と取得
	*	@params $keyID データの指定 $arrayPost 更新データ
	*/
	function getUpdateData($keyID, $arrayPost=array()){
		$this->getDataKey($keyID, 'own');

		if ($arrayPost){
			$this->arrayData['keyID'] = $keyID;
			$this->arrayData['value'] = $arrayPost[$keyID];
			$this->commit();
		}

		return $this->arrayData['value'];
	}

}

?>