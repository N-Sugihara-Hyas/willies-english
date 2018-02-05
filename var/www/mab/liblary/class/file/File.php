<?php

/***********************************************************
*	ファイルのデータを取得するクラス
***********************************************************/
class classFile{
var $fileName;

	/***********************************************************
	*	コンストラクタ
	***********************************************************/
	function classFile($fileName){
		$this->fileName = $fileName;
	}

	/***********************************************************
	*	設定ファイルの取得
	***********************************************************/
	function getSetting($fileName=''){
		if (!$this->fileName){$this->fileName = $fileName;}

		if (file_exists($this->fileName)){
			$arrayFile = file($this->fileName);

			$i = 0;
			foreach ($arrayFile as $item){
				$item = ereg_replace("\n\r|\r|\n", "", $item);
				
				if ($item){
					if (ereg("\[", $item, $regs) ){
						$key = ereg_replace("\[|\]", "", $item);
					}else if (ereg("\(\(", $item, $regs) ){
						$key2 = ereg_replace("\(\(|\)\)", "", $item);
					}else{
						$data = explode('//', $item);
						$item = $data[0];

						if (ereg("\=", $item, $regs) ){
							$num = strpos($item, '=');
							$key3 = substr($item, 0, $num);
							$value = substr($item, $num + 1, strlen($item));

							$key3 = str_replace("\t", "", $key3);
							$value = str_replace("\t", "", $value);
						}else{
							$value.= "\n" . $item;
							$value = str_replace("\t", "", $value);

						}

						$arraySetting[$key][$key2][$key3] = $value;
					}
				}
			}

			return $arraySetting;
		}else{
			return false;
		}
	}

	/***********************************************************
	*	\t区切りのファイルの取得
	***********************************************************/
	function getTab($fileName=''){
		if ($fileName){$this->fileName = $fileName;}

		if (file_exists($this->fileName)){
			$arrayFile = file($this->fileName);

			$i = 0;
			foreach ($arrayFile as $item){
				$arrayFileResult[$i] = explode("\t", $item);
				$i++;
			}
		}

		return $arrayFileResult;
	}

	/***********************************************************
	*	\t区切りの設定ファイルの取得
	***********************************************************/
	function getSettingForm($fileName=''){
		if ($fileName){$this->fileName = $fileName;}

		if (file_exists($this->fileName)){
			$arrayFile = file($this->fileName);

			$i = 0;
			foreach ($arrayFile as $item){
				list($key, $value) = explode("\t", $item);
				$arrayFileResult[$i]['key'] = $key;
				$arrayFileResult[$i]['value'] = $value;
				$i++;
			}
		}

		return $arrayFileResult;
	}

	/***********************************************************
	*	CSVデータでファイル出力
	***********************************************************/
	function getCsv($arrayData, $fileName='', $keyNg){
		if ($fileName){$this->fileName = $fileName;}

		foreach ($arrayData as $item){
			foreach ($item as $key => $value){
				if ($key != $this->arrayAll['type'] . 'No'){
					$keys .= $key . ',';
					$result .= $value . ',';
				}
			}

			if (!$flgFirst){
				$result = substr($keys, 0, strlen($keys) - 1) . "\n" . $result;
			}

			$flgFirst = true;

			$result = substr($result, 0, strlen($result) - 1);
			$result .="\n";
		}

		header("Content-disposition: attachment; filename=" . $this->fileName);
		header("Content-type: application/octet-stream; name=" . $this->fileName);

		print $result;
	}
}

?>