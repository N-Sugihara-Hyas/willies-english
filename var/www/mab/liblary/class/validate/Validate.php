<?php

/*
*	エラー値のチェック
*/
class Validate{
var $arrayError;			//エラー文字の出力
var $isError=false;		//エラーを判定しない


	/*
	*	エラー値を返す
	*	@return エラーデータ
	*/
	function getError(){
		return $this->arrayError;
	}

	/*
	*	エラーチェック
	*	@params $arrayInput
	*
	*/
	function checkDataOwn($input, $arrayType, $key=''){
		$self = $this;
		require_once 'validate/' . $arrayType['type'] . '.php';

		$function = '$strError=$this->' . $arrayType['type'] . "(\$input,\$arrayType, \$key);";
		eval($function);
		
		return $strError;
	}
	
	/*
	*	データ群のエラーチェック
	*	@params $arrayInput
	*
	*/
	function checkData($arrayInput){
		$this->arrayInput = $arrayInput;

		foreach ($this->validate as $key => $arrayItem){

			foreach ($arrayItem as $item2){
				$strError = '';

				$input = getVar($arrayInput, $key);
				
				if (!method_exists($this, $item2['type']) ){
					$strError = $this->checkDataOwn($input, $item2, $key);
				}else{
					$strError = $this->$item2['type']($input, $item2, $key);
				}
				
				if (!empty($strError)){
					//戻り値がbreakの場合は対象のキーのエラーチェックを停止
					if ($strError != 'break'){
						$this->arrayError[$key] = $strError;
						$this->isError = true;
					}
					break;
				}
			}
		}

		return $this->arrayError;
	}

  function __call($name, $args) {
		if (is_callable($this->parent->$name)) {
			return call_user_func_array($this->parent->$name, $args);
		}
   }

}

?>