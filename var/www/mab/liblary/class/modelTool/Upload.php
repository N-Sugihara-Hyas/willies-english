<?php

	/*
	*	該当のファイルをセッションデータを保存
	*	@params $files ファイル $key キー $fileName ファイルの名称がある場合
	*/
	$self->parent->uploadSetSession = function($files, $key, $fileName='') use ($self){
		$arrayUpload['header'] = $files;
		$arrayUpload['body'] = file_get_contents($files['tmp_name']);

		if (!$fileName){
			$arrayUpload['header']['fileName'] = time() . '_' . $key;
		}else{
			$arrayUpload['header']['fileName'] = $fileName;
		}

		//セッションに保存
		$self->setSession('formUpload_' . $key, $arrayUpload);

		return $arrayUpload;
	};

	$self->parent->uploadGetSession = function($key) use ($self){
		return $self->getSession('formUpload_' . $key);
	};

	$self->parent->uploadClearSession = function($key) use ($self){
		$self->setSession('formUpload_' . $key, array());
	};

		/*
		*	データをDBに保存
		*	@params $arrayUpload アップロードのデータ
		*/
	$self->parent->uploadData = function($arrayUpload, $arrayExt=array()) use($self){
		$self->addQuery('fileName', $arrayUpload['header']['fileName']);
		$dbGet = $self->getData();
		$dbGet->getData();

		$dbGet->arrayData['name'] = $arrayUpload['header']['name'];
		$dbGet->arrayData['fileName'] = $arrayUpload['header']['fileName'];
		$dbGet->arrayData['mime'] = $arrayUpload['header']['type'];
		$dbGet->arrayData['body'] = base64_encode($arrayUpload['body']);

		$dirName = $self->arrayDir['dirView'] . 'tmp/' . $self->dirImg . '/';

		//サムネイルの削除
		if (file_exists($dirName . $arrayUpload['header']['fileName']) ){
			unlink($dirName . $arrayUpload['header']['fileName']);
		}

		foreach ($self->arraySize as $item){
			if (file_exists($dirName . $item . '/' . $arrayUpload['header']['fileName']) ){
				unlink($dirName . $item . '/' . $arrayUpload['header']['fileName']);
			}
		}

		//その他がある場合の処理
		foreach ($arrayExt as $key => $item){
			$dbGet->arrayData[$key] = $item;
		}
		
		$dbGet->commit();
	};

		/*
		*	データをDBから消去
		*	@params $arrayUpload アップロードのデータ
		*/
	$self->parent->uploadClear = function($fileName) use($self){
		$self->addQuery('fileName', $fileName);
		$self->delData();

	};

?>