<?php

/*
*	表示関連のクラス
*/
class BaseView{
var $dirHtmlPlus = '';
var $isSmart;
var $arrayVar;


	/*
	*	変数の設定
	*	@param key テンプレートでの変数名 value 変数の内容
	*/
	function set($key, $value){
		$this->arrayVar[$key] =  $value;
	}

	/*
	*	実際のテンプレート表示(ラップ)
	*	@params pageName テンプレート名 $isView HTMLを出力か取得か？
	*/
	function setShow($pageName='', $dirHtml='', $isView=true){
		return $this->_setShow($pageName, '', $isView);
	}

	/*
	*	実際のテンプレート表示
	*	@params pageName テンプレート名 $isView HTMLを出力か取得か？
	*/
	function _setShow($pageName='', $dirHtml='', $isView=true){
		if (!$pageName){$pageName = 'index';}
		if (!$dirHtml){
			if (!empty($this->arrayAction['dir'])){$dirHtml = $this->arrayAction['dir'] . '/';}
		}

		if ($this->arraySetting['outEncoding'] != 'UTF-8'){
			header("Content-type: text/html; charset=" . $this->arraySetting['outEncoding']);
			$this->cSmarty->registerFilter('output', array($this,'changeOutput'));
		}

		$templateName = $this->arrayDir['dirHtml'] . $dirHtml . $pageName . '.html';

		if (!file_exists($templateName)){
			echo ('テンプレート' . $templateName . 'は存在しません');
		}else{
			if ($isView){
				if ($this->arrayVar){
					extract($this->arrayVar);
				}

				require_once $templateName;
			}else{
				//検討中
			}
		}


		exit();
	}


}

?>
