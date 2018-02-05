<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		$this->addModel(array('member/Base', 'cource/Base', 'master/AdminNews', 'take/Base'));


		//共通処理
		$this->getCommon();
		
		$arrayData = $this->arrayUser;
		
		$modelName = 'MemberBase';
		$this->$modelName->addModelTool('Mail');
		$this->$modelName->arrayMail = $this->arrayUser;
		
		//講師
		$objTake = $this->TakeBase->getDataUID($this->arrayUser['take_base_id'])->getData();
		$this->$modelName->arrayMail['nickname'] = $objTake['nickname'];
		
		//コース
		$objCource = $this->CourceBase->getDataUID($this->arrayUser['cource_base_id'])->getData();
		$this->$modelName->arrayMail['courceName'] = $objCource['courceName'];
		
		
		$this->$modelName->arrayMail['student_name'] = $this->arrayUser['memberNameFirstEnglish'] . ' ' .$this->arrayUser['memberNameSecoundEnglish'];
		
		
		//現在の教材の情報取得
		$this->$modelName->arrayMail['current'] = '';
		$arrayType = $this->TeachingBase->getFunctionData('Teaching');
		foreach ($arrayType as $key => $value){			
			$value2 = strtolower($value['value']);
			
			$objText = '';	
			
			if ($this->arrayUser[$value2]){
				$objText = $this->TeachingBase->getDataUID($this->arrayUser[$value2])->getData();
			}
								
			if ($objText){
				$this->$modelName->arrayMail['current'].= "\n・" . $value['value'] . ':' . $objText['teachingName'];
			}
		}		
		

		

		//新しい教材の情報取得
		$this->$modelName->arrayMail['new'] = '';
		$arrayType = $this->TeachingBase->getFunctionData('Teaching');
		foreach ($arrayType as $key => $value){			
			$value2 = strtolower($value['value']);
				
			$objText = '';		
			if ($this->arrayPost[$value2 . '_iti']){
				$objText = $this->TeachingBase->getDataUID($this->arrayPost[$value2 . '_iti'])->getData();
			}
			
			if ($objText){
				$this->$modelName->arrayMail['new'].= "\n・" . $value['value'] . ':' . $objText['teachingName'];
			}
		}		

		
		//管理者に送付
		$this->$modelName->arrayMail['domain'] = $this->arraySetting['domain'];
		$this->$modelName->arrayData['created'] = date('Y-m-d');
		$this->$modelName->isFormData = true;
		$this->$modelName->mailSend(51, array($this->$modelName->arraySetting['email4']));

		$this->$modelName->arrayMail['domain'] = $this->arraySetting['domain'];
		$this->$modelName->arrayData['created'] = date('Y-m-d');
		$this->$modelName->isFormData = true;
		$this->$modelName->mailSend(51, array('rikitikbaby@gmail.com'));
					
			
		//管理者のお知らせに追加
		$this->MasterAdminNews->arrayMail = $this->$modelName->arrayMailSetting;
		$this->MasterAdminNews->addMailData(51,$this->$modelName->arrayMailSetting['body'], $this->$modelName->arrayMailSetting, $objTake['id']);
		
		$this->setRedirect('mypage/');
		
?>