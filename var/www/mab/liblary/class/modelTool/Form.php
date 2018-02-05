<?php


	$self->isError = true;
	$self->editColum = $self->tID;

	/*
	*	各種コンテンツの登録・編集
	*
	*	@param $e 現在の編集タイプ
	*/
	$self->parent->getEdit = function($e) use($self){
		if ($e == 'reInput'){
			$self->arrayInput = $self->getFormData();
			$self->getUID();

			return $self->arrayInput;
		}else if ($e){
			//編集モード
			$self->addQuery($self->tableName . '.' . $self->editColum, $e);
			$self->arrayInput = $self->getData()->getData();
			$self->addUID($e);

			if ($self->arrayInput){
				if (isset($self->parent->updateDataOut)){
					$self->updateDataOut();
				}
				if ($self->arrayInput){
					return $self->arrayInput;
				}
			}
		}

		//フォームデータの初期化
		$self->clearFormData();
		$self->clearUID();
		
		foreach ($self->arrayColum as $key => $item){
			//初期値がある場合の処理
			$self->arrayInput[$key] = getVar($item, 'default');
		}
	
		return $self->arrayInput;
	};


		/*
		*	各種コンテンツの入力確認画面
		*
		*	@param $arrayForm フォームの値
		*/
	$self->parent->getEditConfirmation = function($arrayInput) use($self){
		$self->arrayInput = $arrayInput;
				
		$self->setFormData($arrayInput);
	};

	/*
	*	各種コンテンツの入力完了画面
	*
	*	@return セッションデータがある場合は真、無い場合は偽
	*/
	$self->parent->getEditEnd = function($arrayInput=array()) use ($self){

		if (!$arrayInput){
			$arrayInput = $self->getFormData();
		}


		//DBに入れる値が存在するか？
		if ($arrayInput){
			if (isset($self->modelImage) ){
				$model = $self->getModel($self->modelImage);
				$model->addModelTool('Upload');
			}

			//アップロード情報がある場合は、アップロード処理をする
			foreach ($self->arrayColum as $key => $item){
				if ($item['type'] == 'file'){
					$arrayUpload = $model->uploadGetSession($key);
					
					if ($arrayUpload){
						$model->uploadData($arrayUpload);
						$model->uploadClearSession($key);
					}
				}
			}

			//画像の削除がある場合
			$arrayFileDel = $self->getSession('arrayFileDel');
			if (isset($arrayFileDel[$self->modelName])){
				foreach ($arrayFileDel[$self->modelName] as $item){
					$model->uploadClear($item);
				}
			}

			foreach ($arrayInput as $key => $value){
				$self->arrayData[$key] = $arrayInput[$key];
			}

			//修正の場合はuidをIDとしていれる
			$self->arrayData['id'] = $self->getUID();
			if (!$self->arrayData['id']){unset($self->arrayData['id']);}
			
			if (isset($self->parent->updateData)){
				$self->updateData();
			}


			//DB保存する場合はコミット
			$uid = $self->commit($self->arrayData);

			if (isset($self->parent->updateDataAffter)){
				 $self->updateDataAffter($uid);
			}

		//フォームデータの初期化
		if (DEBUG_MODE == 0){
			$self->clearFormData();
		}

			return $uid;
		}
	};

	/*
	 * 編集時のUIDの削除
	 * @params $modelName モデルの名前
	 */
	$self->parent->clearUID = function() use($self){
		$self->clearSession('form_uID' . $self->arrayAction['dir']);
	};

	/*
	 * 編集時のUIDの保持
	 * @params $uID その編集のユニークID $modelName モデルの名前
	 */
	$self->parent->addUID = function($uID) use($self){
		$self->setSession('form_uID' . $self->arrayAction['dir'], array('uID' => $uID));
	};

	/*
	 * 編集時のUIDの取得
	 * @return UID取得
	 */
	$self->parent->getUID = function() use($self){
		$arrayUID = $self->getSession('form_uID' . $self->arrayAction['dir']);
		
		return getVar($arrayUID, 'uID');
	};

	/*
	 * 一括でカラムデータの変換処理
	 * @return 変換されたカラムデータ
	 */
	function chengeFormDataAll(){
		foreach ($self->arrayColum as $key => $item){
			$self->arrayColum[$key] = $self->chengeFormData($self->arrayColum[$key]);
		}

		return $self->arrayColum;
	}

	$self->parent->formUpload = function($arrayInput) use($self){
		//ファイルのアップロードがある場合の処理
		if (isset($self->modelImage) ){
			$modelImage = $self->getModel($self->modelImage);
			$modelImage->addModelTool($modelImage->type);


			foreach ($_FILES as $key => $item){
				if ($_FILES[$key]['tmp_name']){
					if (empty($_POST['arrayFileDel'][$self->modelName]) ){
						$arrayUpload = $modelImage->uploadSetSession($_FILES[$key], $key, $arrayInput[$key]);
						$arrayInput[$key] = $arrayUpload['header']['fileName'];
					}
				}
			}

			//画像の削除がある場合
			if (!empty($_POST['arrayFileDel'][$self->modelName]) ){
				foreach ($_POST['arrayFileDel'][$self->modelName] as $key => $item){
					$modelImage->uploadClearSession($key);
					$arrayInput[$key] = '';
				}

				$self->setSession('arrayFileDel', $_POST['arrayFileDel']);
			}
		}

		$self->arrayInput = $arrayInput;
	};

	/*
	*	入力値の取得
	*
	*	@return 入力値
	*/
	$self->parent->getFormData = function() use($self){
		return $self->getSession('form' . $self->arrayAction['dir']);
	};

	/*
	*	入力値の設定
	*
	*	@params $arrayInput データ
	*/
	$self->parent->setFormData = function($arrayInput) use($self){		
		$self->setSession('form' . $self->arrayAction['dir'], $arrayInput);
	};

	/*
	 *	セッションデータのクリア
	*/
	$self->parent->clearFormData = function() use ($self){
		$self->clearSession('form' . $self->arrayAction['dir']);
		$self->clearSession('form_formUpload' . $self->arrayAction['dir']);
		$self->clearSession('form_uID' . $self->arrayAction['dir']);
	};

?>