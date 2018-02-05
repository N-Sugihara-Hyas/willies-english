<?php

	/*
	*	CSV関連の扱い
	*/
	class ModelToolCSV extends Model{
	var $arrayCSV=array();	/*CSV形式の出力するデータを配列で設定する*/
	var $classOut;			/*CSV変換処理の際に外部のクラスを指定するか*/
	var $settingCSV='';		/*設定が可能な場合の読み込み書き込み場所

		/*
		 *	別のモデルからCSVクラスの生成
		 *	@params 別のクラス
		*/
		function ModelToolCSV($arrayModel){
			//1番目を基本のモデルにする
			$this->model = $arrayModel[0];

			foreach ($arrayModel as $key => $model){

				if (isset($this->model->arrayCSVType) ){
					foreach ($this->model->arrayCSVType as $key => $item){
						if (is_array($item)){
							if (isset($model->arrayColum[$key])){
								$this->arrayCSV[$key] = $model->arrayColum[$key];
							}else{
								$this->arrayCSV[$key] = array();
							}

							$this->arrayCSV[$key] = array_merge($this->arrayCSV[$key], $item);
						}else{
							if (isset($this->model->arrayColum[$item])){
								$this->arrayCSV[$item] = $model->arrayColum[$item];
							}else{
								$this->arrayCSV[$key] = $item;
								$this->arrayCSV[$key]['id'] = $key;
							}
						}
					}
				}else{
					$this->arrayCSV = array_merge($this->arrayCSV, $model->arrayColum);
				}
			}


		}


		/*
		 * CSVをエクスポート
		 * @params $fileName ファイル名
		 */
		function exportCSV($fileName){
	
			header("Cache-Control: public");
			header("Pragma: public");
			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment; filename=\"" . $fileName);


			$arrayCSV = $this->getSettingCSV($this->model);

			$str = '';

			foreach ($arrayCSV as $key => $item){
				if ($item['checked']){
					$arrayCSVResult[$item['sort']] = $this->arrayCSV;
					$arrayCSVResult[$item['sort']]['id'] = $key;
					$arrayCSVResult[$item['sort']]['name'] = $item['name'];
				}
			}

			ksort($arrayCSVResult);

			foreach ($arrayCSVResult as $key => $item){
				$str.= mb_convert_encoding ($item['name'] .',', 'SJIS', 'UTF-8');
			}

			echo substr($str, 0, strlen($str) -1) . "\n";

			$result = $this->model->getDataResult();

			$class = $this;
			if ($this->classOut){
				$class = $this->classOut;
			}

			if (!isset($this->model->fncChangeDataCsv)){
				$this->model->fncChangeDataCsv = 'changeDataCsv';
			}

			while ($row = mysql_fetch_assoc($result)){
				$str = '';

				$arrayData = $row;


				if (method_exists($this->model, $this->model->fncChangeDataCsv) ){
					$fnc = $this->model->fncChangeDataCsv;

					$arrayData = $this->model->$fnc($arrayData);
				}

				$arrayData = $this->model->changeViewDatas($arrayData);


				foreach ($arrayCSVResult as $key => $item){
					if (isset($arrayData[$item['id']])){
						$str.= mb_convert_encoding ($arrayData[$item['id']] .',', 'SJIS', 'UTF-8');
					}
				}

				echo substr($str, 0, strlen($str) -1) . "\n";
			}

			exit();
		}



		/*
		 * CSVをインポートしてデータに挿入
		 * @params $fileName インポートデータのファイル名  $validateName エラーチェック $encode 文字コード $first 開始行 $validate エラーチェックの限定
		 * @return エラー
		 */
		function importCSV($fileName, $validateName='', $encode='UTF-8', $first=2, $validate=''){
			require_once 'Form.php';

			$arrayError = array();
			$error = '';

			$fp = fopen($fileName, 'r');

			//エラーチェックの設定
			$ToolForm = new ToolForm($this->model->modelName . '_form');

			$ToolForm->id = 0;

			//テーブルを出力
			$num = 1;
			while ($arrayCsv = fgetcsv($fp, 4096, ',')) {
				if ($num >= $first){

					$i = 0;
					foreach ($this->arrayCSV as $key => $item){
						if (isset($arrayCsv[$i])){
							$arrayData[$key] = mb_convert_encoding($arrayCsv[$i], 'UTF-8', $encode);
							$i++;
						}
					}

					//変換処理があるか？
					if (method_exists($this->model, 'changeCsvData') ){
						$arrayData = $this->model->changeCsvData($arrayData);
					}

					//エラー処理
				//	if ($validateName){
				//		if (!$ToolForm->getConfirmation($arrayData, $validateName, $validate)){
				//			$error = '';
				//			foreach ($ToolForm->arrayError as $item){
				//				$error.=$item;
				//			}

					//		$error .= $no . '行目に「' . $error . '」の入力ミスがあります。<br>';
					//	}else{
							$this->model->arrayData = $arrayData;

					//		if ($this->arrayData){
								$uid = $this->model->commit();

								//変換処理があるか？(処理後)
								if (method_exists($this->model, 'changeCsvDataAffter') ){
									$arrayData = $this->model->changeCsvDataAffter($arrayData, $uid);
								}

						//	}
						//}
					//}
				}

				$num++;

			}

			if ($error){
				return $error;
			}
		}


		/*
		*	CSVの設定ファイルの書き込み
		*	@params $isSave 保存するか $arrayData データ
		*/
		function setSettingCSV($isSave, $arrayData){
			$tmpName = $this->settingCSV;

			foreach ($this->arrayCSV as $key => $item){
				if (!empty($arrayData['view'][$key])){
					$arrayCSV[$key]['checked'] = 1;
				}else{
					$arrayCSV[$key]['checked'] = 0;
				}

				$arrayCSV[$key]['sort'] = $arrayData['sort'][$key];
			}

			if ($isSave){
				$data = '<?php' . "\n";
				$data.= '$arrayCSV = array' . "(\n";

					foreach ($arrayCSV as $key => $item){
						$data.= "'" . $key . "' => array(\n";
						$data.= "'checked' => " . $item['checked'] . ",\n";
						$data.= "'sort' => " . $item['sort'] . ",\n";
						$data.= "),\n";
					}

				$data.=');';
				$data.= '?>';

				$fp = fopen($tmpName, 'w');
				fwrite($fp, $data);
				fclose($fp);
			}

			session_start();
			$_SESSION[$this->settingCSV] = $arrayCSV;

		}

		/*
		*	CSVの設定ファイルの読み込み
		*	@return 表示データ
		*/
		function getSettingCSV(){
			$tmpName = $this->settingCSV;

			$isData = true;
			//CSVの設定ファイルが無い場合は、全初期状態に
			if (!file_exists($tmpName)){
				$isData = false;
			}

			if (isset($_SESSION[$tmpName]) ){
				$arrayCSV = $_SESSION[$tmpName];
				$isData = true;
			}else{
				if ($isData){
					require_once $tmpName;
				}
			}


			$arrayResult = array();
			$i = 1;
			foreach ($this->arrayCSV as $key => $item){
				if (isset($this->arrayCSV[$key]['name']) ){
					$arrayResult[$key]['name'] = $this->arrayCSV[$key]['name'];

					if (!$isData){
						$arrayResult[$key]['checked'] = 1;
						$arrayResult[$key]['sort'] = $i;
					}else{
						$arrayResult[$key]['checked'] = $arrayCSV[$key]['checked'];
						$arrayResult[$key]['sort'] = $arrayCSV[$key]['sort'];
					}

					$i++;
				}
			}
			return $arrayResult;
		}

		/*
		*	CSVの設定の消去
		*/
		function clearSettingCSV(){
			session_start();
			unset($_SESSION[$this->settingCSV]);
		}

	}

?>