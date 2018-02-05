<?php

	/*
	*	モデルのベース
	*/
	class Model{
	var $unSelect = '';

		/*
		 * モデル内に別のモデルの追加
		 * @parmas modelName モデル名
		 */
		function getModel($modelName){
			$model = getModel($modelName);

			$model->arrayDir = $this->arrayDir;
			$model->arrayAction = $this->arrayAction;
			$model->arraySetting = $this->arraySetting;

			return $model;
		}

		/*
		 * モデル内にライブラリの追加
		 * @parmas liblaryName ライブラリ名
		 */
		function addLiblary($liblaryName){
			require_once dirname(__FILE__) . '/../' . $liblaryName . '.php';
		}


		/*
		*	データをセッションから取得
		*	@params $id IDを指定
		*/
		function getSession($id){
			require_once dirname(__FILE__) . '/../securty/Session.php';

			//
			$cSession = new SecurtySession($this->modelName . '_' . $id);
			return $cSession->getData();
		}

		/*
		 *	セッションデータの更新
		 *	@params $id 識別ネーム $arrayInput データ 
		*/
		function setSession($id, $arrayInput){
			require_once dirname(__FILE__) . '/../securty/Session.php';

			$cSession = new SecurtySession($this->modelName . '_' . $id);


			$cSession->arrayData = $arrayInput;

			$cSession->commit();
		}
		/*
		 *	セッションデータの更新
		*/
		function clearSession($id){
			require_once dirname(__FILE__) . '/../securty/Session.php';

			$cSession = new SecurtySession($this->modelName . '_' . $id);
			$cSession->arrayData = array();
			$cSession->commit();
		}

		/*
		*	カラムデータの取得
		*	@params $arrayColum カラムデータがある場合は指定
		*/
		function setColum($colum=''){
			$this->addModelTool('Colum');

			if (!$colum){$colum = $this->modelDir;}

			$self = &$this;

			require_once $this->arrayDir['dirContents'] . 'colum/' . $colum . '.php';

			$this->arrayColum = $arrayColum;
		}

		/*
		 * 外部関数からデータの配列の取得
		 * @params $data PHP名の設定 $ext その他情報
		 */
		function getFunctionData($data, $ext=''){
			require_once $this->arrayDir['dirConf'] . 'setting/' . $data  . '.php';

			$function = 'getSelect' . $data;
			
			$arrayData = $function($this, $ext);

			if ($this->unSelect){
				array_unshift($arrayData, array('id' => '', 'value' => $this->unSelect));
			}

			return $arrayData;
		}

		/*
		 * 対象のデータをキーに外部関数からデータの取得
		 * @params $data PHP名の設定 $ext その他情報
		 */
		function getFunctionDataOwn($data, $input, $ext=''){
			require_once $this->arrayDir['dirConf'] . 'setting/' . $data  . '.php';

			$function1 = 'getSelect' . $data . 'Own';
			if (function_exists($function1)){
				return $function1($this, $input, $ext);
			}else{
				$function2 = 'getSelect' . $data;
				$arrayData = $function2($this, $ext);

				if (isset($arrayData[$input]['value'])){
					return $arrayData[$input]['value'];
				}else{
					return '';
				}
			}
		}

		/*
		*	モデルツール関連
		*	@params $type モデルツール名
		*/
		function addModelTool($type){
			$self = &$this;

			require $this->arrayDir['dirClass'] . 'modelTool/' . $type . '.php';
		}

    function __call($name, $args) {
			if (is_callable($this->parent->$name)) {
				return call_user_func_array($this->parent->$name, $args);
			}else{
				echo $name;
			}
    }
	}

?>