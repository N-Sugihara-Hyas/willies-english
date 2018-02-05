<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		$this->addModel(array('teaching/Base', 'teaching/Lesson'));

		//共通処理
		$this->getCommon();

		ini_set('auto_detect_line_endings', 1);
		
		$file = new SplFileObject($_FILES['csv']['tmp_name']);
		$file->setFlags(SplFileObject::READ_CSV);
		//$file->setFlags(SplFileObject::DROP_NEW_LINE);
		
		
		
		$i = 0;
		foreach ($file as $line){
			if ($i){
				$line[0] = mb_convert_encoding($line[0], 'UTF-8', 'SJIS');
				
				$this->TeachingBase->addQuery('teachingName', $line[0]);
				$objTeaching = $this->TeachingBase->getData()->getData();

				$arrayCategory = array();
				$arrayCat = explode('<>', $line[2]);
				foreach ($arrayCat as $value){
					$arrayCategory[$value] = $value;
				}
								
				$arrayCategory = json_encode($arrayCategory);
												
				if (!$objTeaching){
					$objTeaching['teachingName'] = $line[0];
					$objTeaching['sort'] = $line[1];
					$objTeaching['category'] = $arrayCategory;
					
					$bid = $this->TeachingBase->commit($objTeaching);
				}else{
					$bid = $objTeaching['id'];
				}
				
				$objData['teaching_base_id'] = $bid;
												
				$objData['category'] = $arrayCategory;
				$objData['sort'] = $line[3];
				$objData['lessonName'] = mb_convert_encoding($line[4], 'UTF-8', 'SJIS');
								
				
				$this->TeachingLesson->addData($objData);
			}
			
			$i++;

		} 

		
		$this->setRedirect('teachingLesson/list/');
		
?>