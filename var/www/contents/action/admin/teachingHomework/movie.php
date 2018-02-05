<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		$this->addModel(array('teaching/Homework'));

		//共通処理
		$this->getCommon();


		
		$dirMovie = $this->arrayDir['dirTmp'] . 'upload/movie';
		if (!file_exists($dirMovie)){
			mkdir($dirMovie);	
		}
		
		$fileName = '';
		if ($_FILES['movie']['tmp_name']){
			$fileName = uniqid();
			rename($_FILES['movie']['tmp_name'], $dirMovie . '/' . $fileName);
		}
		
		

		
		$objData['id'] = $this->uid;
		$objData['file'] = $fileName;
		$objData['body'] = $this->arrayAll['body'];;
						
		$this->TeachingHomework->commit($objData);
		
		if (!empty($this->arrayAll['redirect'])){
			$this->setRedirect($this->arrayAll['redirect']);			
		}else{
			$this->setRedirect('teachingHomework/end/' . $this->uid);
		}
?>