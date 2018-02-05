<?php

/*
*	ディレクトリ関連のクラス
*/
class FileDir{
var $result_dir = array();

	/*
	*	コンストラクタ
	*/
	function  FileDir(){

	}

	/*
	*	指定のディレクトリが無ければ作る
	*	@params $dir ディレクトリ名　$mode ディレクトリモード
	*/
	function setMkDir($dir, $mode=0666){

		if (!is_dir($dir)){
			mkdir($dir, $mode);
		}

	}

	/*
	*	ディレクトリを空にする
	*	@params $dir ディレクトリ名
	*/
	function delDirAll($dir) {
		  if ($handle = opendir("$dir")) {
		   while (false !== ($item = readdir($handle))) {
		     if ($item != "." && $item != "..") {
		       if (is_dir("$dir/$item")) {
		         $this->delDirAll($dir . '/' . $item);
		       } else {
		         unlink($dir . '/' . $item);
		       }
		     }
		   }
		   closedir($handle);
				rmdir($dir);
		  }
	}

	/*
	*	指定したディレクトリのファイル一覧をrequire_once
	*	引数:ディレクトリ名
	*	戻り値:一覧の取得
	*/
	function getFileDataAll($dir, $require_flag='') {
		if ($handle = opendir($dir)) {
			$i= 0;
			
			while (false !== ($item = readdir($handle))) {
				if ($item != "." && $item != "..") {
					if (is_dir($dir . '/' . $item)) {
						$this->getFileDataAll($dir . '/' . $item . '/', $require_flag);
		      }else{
						if ($require_flag){
							require_once $dir . $item;
						}else{
			        $this->result_dir[count($this->result_dir) + 1] = $dir . $item;
						}
		      		}
					$i++;
		     	}
		   	}

			closedir($handle);
		  }

		return $this->result_dir;
	}

	/*
	*	指定したディレクトリのファイル一覧のリスト取得
	*	引数:ディレクトリ名
	*	戻り値:一覧の取得
	*/
	function getFileList($dir){
		$result = array();
    	if (is_dir($dir)) {
    		if ($dh = opendir($dir)) {
    			while (($file = readdir($dh)) !== false) {
    				if(is_dir($dir . $file) && $file != '.' && $file != '..'){
    					if ($dh2 = opendir($dir.$file)) {
    						while (($file2 = readdir($dh2)) !== false) {
    							if(is_dir($dir.$file."/".$file2) && $file2 != '.' && $file2 != '..' && $file2 != '.metadata'){
    								$result = array_merge($result,  $this->getFileList($dir.$file."/".$file2."/"));
    							}else if($file2 != '.' && $file2 != '..' && $file2 != '.metadata'){
    								$result[] = $dir.$file."/".$file2;
    							}
    						}
    					}
    				}else if($file != '.' && $file != '..'){
    					$result[] = $dir.$file;
    				}
    			}
    		}
    	}
    	
    	return $result;
	}
	

	/*
	*	ディレクトリ単位で、requireする
	*	引数:ディレクトリ名
	*	戻り値:なし
	*/
	function setRequire($reqName){
		$lib_data1 = $this->getFileDataAll($reqName, 'true');
	}

	/*
	 * ディレクトリのコピー
	 */
	function copyDir($imageDir, $destDir){
		if (!file_exists($destDir) ){
			mkdir($destDir);
		}

		$handle=opendir($imageDir);

		while($filename=readdir($handle)){
			if(strcmp($filename,".")!=0
			&& strcmp($filename,"..")!=0){

				if(is_dir("$imageDir/$filename")){
					if(!empty($filename) && !file_exists("$destDir/$filename")){
						mkdir("$destDir/$filename");
					}

					$this->copyDir("$imageDir/$filename","$destDir/$filename");
				}else{
					if(file_exists("$destDir/$filename")){
						unlink("$destDir/$filename");
					}

					copy("$imageDir/$filename","$destDir/$filename");
				}
			}
		}
	}

}

?>