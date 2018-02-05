<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		$this->addModel(array('teaching/Homework', 'teaching/HomeworkCard'));

		//共通処理
		$this->getCommon();

		ini_set('auto_detect_line_endings', 1);
		$file = new SplFileObject($_FILES['csv']['tmp_name']);
		$file->setFlags(SplFileObject::READ_CSV);
		
		

		$i = 0;
		foreach ($file as $line){
			if ($i){
				$body1 = mb_convert_encoding($line[0], 'UTF-8', 'SJIS');
				$body2 = mb_convert_encoding($line[1], 'UTF-8', 'SJIS');

				
				$objData['teaching_homework_id'] = $this->uid;
				$objData['body1'] = $body1;
				$objData['body2'] = $body2;			
				
				
				$this->TeachingHomeworkCard->addData($objData);
			}
			
			$i++;

		} 
		
		if (!empty($this->arrayAll['redirect'])){
			$this->setRedirect($this->arrayAll['redirect']);			
		}else{
			$this->setRedirect('teachingHomework/end/' . $this->uid);
		}
		
?>