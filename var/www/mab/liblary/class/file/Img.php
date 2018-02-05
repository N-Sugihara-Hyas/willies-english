<?php
/*
*	画像関係の処理
*/
class FileImg{
var $strImgFile;		//画像ファイル名
var $strImgFileData;
var $strImgFileT;		//サムネイルのファイル名
var $arrayImgInfo;		//画像の情報
var $w;					//サムネイルの横サイズ
var $h;					//サムネイルの縦サイズ

	/*
	*	コンストラクタ
	*	@params $srtImgFile ファイル名 $w 横幅 $h 縦幅
	*/
	function FileImg($strImgFile='', $w=0, $h=0){
		if ($strImgFile){
			$this->strImgFile = $strImgFile;

			//リサイズがある場合
			if (($w) || ($h) ){
				$pos = strrpos($strImgFile, '/');
				$dir = substr($strImgFile, 0, $pos) . '/' . $w  . 'x' . $h;

				if (!file_exists($dir) ){
					mkdir($dir);
					chmod($dir, 0777);
				}

				$this->strImgFileT = $dir . substr($strImgFile, $pos);
				$this->fileName = $dir . substr($strImgFile, $pos);
			}
		}

		$this->w = $w;
		$this->h = $h;
	}

	/*
	*	画像ファイルからの取得
	*/
	function getImgFile($flgT=false){
		//サムネイル指定がある場合は、こちらを読み込む
		if ($flgT){
			$strImgFile = $this->strImgFileT;
		}else{
			$strImgFile = $this->strImgFile;
		}
		$arrayImgInfo = getimagesize($strImgFile, $imageinfo);

		if ($arrayImgInfo['mime'] == 'image/png') {
			$arrayImgInfo['image'] = imagecreatefrompng($strImgFile);
		} else if ( ($arrayImgInfo['mime'] == 'image/jpeg') || ($arrayImgInfo['mime'] == 'image/pjpeg') ){
			$arrayImgInfo['image'] = imagecreatefromjpeg($strImgFile);
		} else if ($arrayImgInfo['mime'] == 'image/gif') {
			$arrayImgInfo['image'] = imagecreatefromgif($strImgFile);
		}

		$this->arrayImgInfo = $arrayImgInfo;
	}

	/*
	*	画像の拡大、縮小
	*/
	function setScale($binary=''){
		if (!file_exists($this->strImgFileT) || $binary){
			//サムネイルが存在しない場合は生成
			if ($binary){
				//バイナリデータで指定
				$this->arrayImgInfo['image'] = imagecreatefromstring($binary);
				$this->arrayImgInfo[0] = imagesx($this->arrayImgInfo['image']);
				$this->arrayImgInfo[1] = imagesy($this->arrayImgInfo['image']);
				$this->arrayImgInfo['mime'] = 'image/jpeg';
			}else{
				$this->getImgFile();
			}

			$isJudg = false;

			if (!$this->w){$isJudg = true;$this->w = intval($this->arrayImgInfo[0] * ($this->h / $this->arrayImgInfo[1]));}
			if (!$this->h){$isJudg = true;$this->h = intval($this->arrayImgInfo[1] * ($this->w / $this->arrayImgInfo[0]));}

			if ($this->arrayImgInfo['mime'] == 'image/gif'){
				$dst = imagecreate($this->w, $this->h);
			}else	if ($this->arrayImgInfo['mime'] == 'image/png'){
				$dst = imagecreatetruecolor($this->w, $this->h);
				//ブレンドモードを無効にする
				imagealphablending($dst, false);
				//完全なアルファチャネル情報を保存するフラグをonにする
				imagesavealpha($dst, true);
			}else{
				$dst = imagecreatetruecolor($this->w, $this->h);
			}

			$sw = $this->arrayImgInfo[0];
			$sh = $this->arrayImgInfo[1];
			$gw = $sw/ $this->w;
			$gh = $sh / $this->h;
				
				
			if (!$isJudg){
				//どちらかが0の場合
				if ($gw < $gh) {
		   		$cut = ceil((($gh - $gw) * $this->h) / 2);
		   		imagecopyresampled($dst, $this->arrayImgInfo['image'], 0, 0, 0, $cut, $this->w, $this->h, $sw, $sh - ($cut * 2));
		    }else if ($gh < $gw) {
					$cut = ceil((($gw - $gh) * $this->w) / 2);
					imagecopyresampled($dst, $this->arrayImgInfo['image'], 0, 0, $cut, 0, $this->w, $this->h, $sw - ($cut * 2), $sh);
		    }else{
					imagecopyresampled($dst, $this->arrayImgInfo['image'], 0, 0, 0, 0, $this->w, $this->h, $this->arrayImgInfo[0], $this->arrayImgInfo[1]);
				}
			}else{
				//両方共指定のある場合
				imagecopyresampled($dst, $this->arrayImgInfo['image'], 0, 0, 0, 0, $this->w, $this->h, $this->arrayImgInfo[0], $this->arrayImgInfo[1]);
			}
			
			$this->arrayImgInfo['image'] = $dst;
		}else{
			$this->getImgFile(true);
		}
	}


	/*
	*	画像の保存
	*/
	function setImgSave(){
		if ($this->arrayImgInfo['mime'] == 'image/png') {
			imagepng($this->arrayImgInfo['image'], $this->strImgFileT);
		} else if ( ($this->arrayImgInfo['mime'] == 'image/jpeg') || ($this->arrayImgInfo['mime'] == 'image/pjpeg') ){
			imagejpeg($this->arrayImgInfo['image'], $this->strImgFileT);
		}else if ($this->arrayImgInfo['mime'] == 'image/gif') {
			imagegif($this->arrayImgInfo['image'], $this->strImgFileT);
		}
	}

	/*
	*	画像の表示
	*/
	function viewShow(){
		if ($this->arrayImgInfo['mime'] == 'image/png') {
			header("Content-type: image/png");
			//ブレンドモードを無効にする
			imagealphablending($this->arrayImgInfo['image'], false);
			//完全なアルファチャネル情報を保存するフラグをonにする
			imagesavealpha($this->arrayImgInfo['image'], true);
			imagepng($this->arrayImgInfo['image']);
		} else if ( ($this->arrayImgInfo['mime'] == 'image/jpeg') || ($this->arrayImgInfo['mime'] == 'image/pjpeg') ){
			header("Content-type: image/jpeg");
			
			imagejpeg($this->arrayImgInfo['image']);
		}else if ($this->arrayImgInfo['mime'] == 'image/gif') {
			header("Content-type: image/gif");
			imagegif($this->arrayImgInfo['image']);
		}
	}
}

?>