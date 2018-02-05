<?php


	/*
	*	指定したディレクトリのPHP一覧を取得
	*	引数:ディレクトリ名
	*	戻り値:一覧の取得
	*/
	function getFileDataAll($dir) {
		if ($handle = opendir($dir)) {
			while (false !== ($item = readdir($handle))) {
				if ($item != "." && $item != ".." && $item != ".svn") {
					require_once $dir . $item;
			  }
			}
		}

		closedir($handle);
	}

	/*
	*	モデルベースの取得
	*	引数:変数
	*	戻り値：$modelName モデル名
	*/
	function addModel($modelName){
		require_once $GLOBALS['arrayDir']['dirClass'] . 'model/' . $modelName . '.php';
	}

	/*
	*	モデルベースの取得
	*	@params $modelDir 設置するモデル名
	*	戻り値：$modelName モデル名
	*/
	function getModel($modelDir){
		require_once $GLOBALS['arrayDir']['dirContents'] . 'model/' . $modelDir . '.php';

		$modelName = ucfirst(str_replace('/', '', $modelDir) );

		$model = new $modelName;
		$model->modelName = $modelName;
		$model->modelDir = $modelDir;

		return $model;
	}

	/*
	*	バリデートのクラスの取得
	*	引数:変数
	*	@params $validateName バリデート名
	*/
	function getValidate($validateName){
		require_once $GLOBALS['arrayDir']['dirClass'] . 'validate/Validate.php';
		require_once $GLOBALS['arrayDir']['dirValidate'] . $validateName . '.php';

		$validateName = 'Validate' . ucfirst(str_replace('/', '', $validateName) );

		$validate = new $validateName();
		$validate->validateName = $validateName;

		return $validate;
	}

	/*
	*	指定した変数が存在しない場合は空欄を入れて返す
	*	引数:変数
	*	戻り値:空の値が入った変数
	*/
	function getVar($str, $key){
		if ($key){
			if (!isset($str[$key]) ){
				$str[$key] = '';
			}
		}else{
			if (!isset($str) ){
				$str = '';
			}
		}

		return $str[$key];
	}

	function out($str, $num=0){
		$str = strip_tags($str, '<br>');

		if ($num){
			$str = mb_strimwidth($str, 0, $num, '...', 'utf-8');
		}

		echo $str;
	}


	function getNew($new, $day, $date){
		$time = strtotime($date);

		$time2 = time() - ($day * (24 * 3600));

		if ($time2 <= $time){
			echo $new;
		}

	}

	/*
	*	指定したテンプレート場所に画像が存在するか
	*	引数:$model モデル $img ファイル名 $ext 縮小サイズ
	*	戻り値:空の値が入った変数
	*/
	function getImg($modelName, $img, $ext=''){
		$model = getModel($modelName);

		if (!$img){
			echo '/common/img/noImage/' . $ext . '.png';
			return;
		}


		$file = 'tmp/' . $model->dirImg . '/';

		if (!file_exists($file) ){
			mkdir($file, 0777);
			mkdir($file . $ext, 0777);
		}



		if ($ext){
			$file .= $model->arraySize[$ext] . '/' . $img;
		}else{
			$file .= '/' . $img;
		}

		if (file_exists($GLOBALS['arrayDir']['dirView'] . $file) ){
			$resultImg = '/' . $file;
		}else{
			$resultImg = '/api/' . $model->dirImg . '/' . $img . '/' . $ext;
		}

		echo $resultImg;
	}

	function getNavi($arrayQuery){
		$my = $_SERVER['REQUEST_URI'];

		foreach ($arrayQuery as $key => $item){
			$my = preg_replace('/' . $key . '=(.+?)&/','',$my);
			$my = preg_replace('/&' . $key . '=(.+?)/','',$my);
			$my = preg_replace('/' . $key . '=(.+?)/','',$my);
			$my.= '&' . $key . '=' . $item;
		}

		
		echo $my;

	}

	function json_decode_mab($json, $isArray=true){
		
		$json = str_replace('undefined', '""', $json);		
		$json = str_replace('null', '""', $json);		
		$json = str_replace('[]', '"test"', $json);		
		$json = preg_replace("/\r\n|\r|\n/", "a", $json);
		$json = str_replace('""""', '""', $json);		
		
		//echo $json;
		//exit();
		
		$arrayJson = json_decode($json, $isArray);		
		
  /*switch (json_last_error()) {
        case JSON_ERROR_DEPTH:
            echo ' - Maximum stack depth exceeded';
        break;
        case JSON_ERROR_STATE_MISMATCH:
            echo ' - Underflow or the modes mismatch';
        break;
        case JSON_ERROR_CTRL_CHAR:
            echo ' - Unexpected control character found';
        break;
        case JSON_ERROR_SYNTAX:
            echo ' - Syntax error, malformed JSON';
        break;
        case JSON_ERROR_UTF8:
            echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
        break;
        
    }*/
     
 
		return $arrayJson;
	}
?>