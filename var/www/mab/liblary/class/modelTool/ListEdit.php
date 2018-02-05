<?php
	require_once dirname(__FILE__) . '/../model/Model.php';

	/*
	*	一覧と変更と追加を行うクラス
	*/
	class ModelToolListEdit extends Model{

		/*
		 *	コンストラクタ
		*	@params $model モデル
		*/
		function ModelToolListEdit($model){
			$this->model = &$model;
		}

		/*
		*	情報の取得
		*/
		function getData(){
			return $this->model->getData();
		}

		/*
		*	情報の更新
		*/
		function reflashData($arrayData){
			$this->model->DBBase->clear();

			foreach ($arrayData as $item){
				$isCommit = true;

				if (isset($this->model->arrayTarget)){
					foreach ($this->model->arrayTarget as $item2){
						if (empty($item[$item2])){
							$isCommit = false;
						}
					}
				}

				if ($isCommit){
					$this->model->arrayData = $item;
					$this->model->commit();
				}
			}
		}

	}
?>