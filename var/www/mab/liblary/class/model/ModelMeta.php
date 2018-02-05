<?php
	require_once dirname(__FILE__) . '/ModelDB.php';


	/*
	*	メタのモデル
	*/
	class ModelMeta extends ModelDB{
	var $group = '*';

		/*
		*	連結
		*/
		/*function joinCourceStyle($model, ){
			$this->addJoins(
				array('model' => 'cource/Style', 'on' => 'cource_style.id=setting_meta.value')
			);
		}*/

		/*
		*	IDを指定して、メタデータの取得
		*	@params $id キー $keyArray 配列のキーを何にするか？
		*/
		function getMeta($id, $keyArray='value'){
			$this->addQuery($this->tableName . '.id', $id);
			$dbGet = $this->getData();
			$arrayResult = array();

			while ($item = $dbGet->getData()){
				$arrayResult[$item[$keyArray]] = $item['value'];
			}

			return $arrayResult;
		}

		/*
		*	IDを指定して、メタデータの全ての情報の取得
		*	@params $id キー $keyArray 配列のキーを何にするか？
		*/
		function getMetaAll($id, $keyArray='value'){
			$this->addQuery($this->tableName . '.id', $id);
			$dbGet = $this->getData();
			$arrayResult = array();

			while ($item = $dbGet->getData()){
				$arrayResult[$item[$keyArray]] = $item;
			}

			return $arrayResult;
		}

		/*
		*	メタデータの追加
		*	@params $id キー $value 内容
		*/
		function addMeta($id, $value){
			$this->addData(array('created' => date('Y-m-d H:i:s'),'modified' => date('Y-m-d H:i:s'), 'id' => $id, 'value' => $value));
		}

		/*
		*	配列からメタデータの作成
		*	@params $id キー $arrayData 内容の配列
		*/
		function setMetaArray($id, $arrayData){
			//一度、削除
			$this->addQuery('id', $id);
			$this->delData();

			//再挿入
			foreach ($arrayData as $item){
				$this->addMeta($id, $item);
			}
		}
	}
?>