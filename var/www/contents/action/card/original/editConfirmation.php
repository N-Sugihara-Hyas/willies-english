<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		require_once 'conf.php';
		$this->addModel(array($arraySetting['base']['modelDir'] . '/' . $arraySetting['base']['modelName']));
		$this->addValidate(array($arraySetting['base']['validateDir'] . '/' . $arraySetting['base']['validateName']));

		$modelName = ucwords($arraySetting['base']['modelDir']) . $arraySetting['base']['modelName'];
		$validateName = 'Validate' . ucwords($arraySetting['base']['validateDir']) . $arraySetting['base']['validateName'];

		//共通処理
		$this->getCommon();

		$this->$modelName->addModelTool('Form');
		$this->$modelName->setColum();
		$this->$modelName->uid = $this->arrayUser['id'];
		$this->$modelName->type = 2;


		$this->$validateName->$modelName = &$this->$modelName;


		$this->$modelName->formUpload($this->arrayPost['arrayInput'][$modelName]);

		$this->set('e', getVar($this->arrayAll, 'e'));
		$this->set('modelName', $modelName);
		$this->set('arrayError', $this->$validateName->arrayError);
		$this->set('arraySettingAdmin', $arraySetting['base']);
		$this->set('uid', $this->$modelName->getUID());
		$this->set('arrayInput', 	$this->$modelName->arrayInput);

		if (empty($this->arrayAll['sub1'])){
			unset($this->$validateName->validate['body1']);
			unset($this->$validateName->validate['body2']);
		}


		if ($arrayError = $this->$validateName->checkData($this->$modelName->arrayInput) ){
			$this->set('arrayError', $this->$validateName->arrayError);
			$this->set('arrayColum', $this->$modelName->arrayColum);

			$this->setShow('edit');
		}else{
			$this->$modelName->getEditConfirmation($this->$modelName->arrayInput);

			if (!empty($this->arrayAll['sub0'])){
				$this->$modelName->addCard($this->$modelName->arrayInput);
				$page = $this->$modelName->getPage();
				$this->$modelName->setPage($page-2);
				$this->setRedirect('card/original/edit/reInput/');
			}

			if ((!empty($this->arrayAll['sub1'])) || (!empty($this->arrayAll['sub2']))){
				if (($this->$modelName->arrayInput['body1']) && ($this->$modelName->arrayInput['body2'])){
					$this->$modelName->addCard($this->$modelName->arrayInput);
				}

				if (empty($this->arrayAll['sub2'])){
					$this->setRedirect('card/original/edit/reInput/');
				}
			}
			if (!empty($this->arrayAll['sub2'])){
				$this->$modelName->getEditConfirmation($this->$modelName->arrayInput);
				$this->setRedirect('card/original/editEnd/');
			}


			$this->set('arrayColum', $this->$modelName->arrayColum);
		}


?>