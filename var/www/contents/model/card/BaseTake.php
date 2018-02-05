<?php

	require_once 'Base.php';

	/*
	*	カードのクラス
	*/
	class CardBaseTake extends CardBase{

		function addFeedBack($arrayData, $cid){
			if (isset($this->isMail)){
				$this->addLiblary('mail/QdMail');
				$MemberBase = $this->getModel('member/Base');
	
				$MailQdMail = new MailQdMail();
	
	
				$arrayUser = $MemberBase->getDataUID($arrayData['member_base_id'])->getData();
				
				$MailQdMail->to(array($arrayUser['email']));
				$MailQdMail->subject($arrayData['cardName']);
				$MailQdMail->setBody($arrayData['free']);
				$MailQdMail->from($this->arraySetting['from'], $this->arraySetting['title']);
				$MailQdMail->_send();
	
				//メールヒストリーにも保存
				$MasterMailLog = $this->getModel('master/MailLog');
				$MasterMailLog->addLog($arrayUser['email'], $arrayData['cardName'], $arrayData['free'], $arrayData['member_base_id']);
			}else{
				$this->arrayData = array();
								
				$this->arrayData['member_base_id'] = $arrayData['member_base_id'];
				$this->arrayData['take_base_id'] = $arrayData['take_base_id'];
	
				$this->addModelTool('Mail');
	
				//ユーザー情報取得
				$MemberBase = $this->getModel('member/Base');
				$arrayMember = $MemberBase->getDataUID($this->arrayData['member_base_id'])->getData();
				
				//レベルの入力があれば更新も
				if ($arrayData['level']){
					$arrayMember['level'] = $arrayData['level'];
					$MemberBase->commit($arrayMember);
				}
	
				//テンプレの種類が1以外
				if ($arrayData['temp'] != 1){
					$this->arrayData['member_base_id'] = $arrayData['member_base_id'];
					$this->arrayData['take_base_id'] = $arrayData['take_base_id'];

					$this->arrayMail = $arrayMember;
					$this->arrayMail['memberName'] = $arrayMember['memberNameSecound'] . ' ' . $arrayMember['memberNameFirst'];
		
		
					//入力した講師情報取得
					$TakeBase = $this->getModel('take/Base');
					$arrayTake = $TakeBase->getDataUID($this->arrayData['take_base_id'])->getData();
					
					$this->arrayMail = array_merge($this->arrayMail, $arrayTake);
					$this->arrayMail = array_merge($this->arrayMail, $this->arrayData);
		
		
					//担当講師情報取得
					$TakeBase = $this->getModel('take/Base');
					$arrayTake = $TakeBase->getDataUID($arrayMember['take_base_id'])->getData();
					
					$this->arrayMail['nickname2'] = $arrayTake['nickname'];
					$this->arrayMail['feedback'] = $arrayData['comment'];
					$this->arrayMail['free'] = $arrayData['comment'];
					$this->arrayMail['id'] = $cid;
					$this->arrayMail['domain'] = $this->arraySetting['domain'];
		
					//メール処理
					$arrayMailList = array('', '',36, 38, 37, 39, 40, 41);
					$mailType = $arrayMailList[$arrayData['temp']];
		
					$AdminMail = $this->getModel('admin/Mail');
					$arrayMail = $AdminMail->getDataUID($mailType)->getData();
		
					foreach ($this->arrayMail as $key => $item){
						$arrayMail['body'] = str_replace('({$' . $key . '})', $item, $arrayMail['body']);
						$arrayMail['subject'] = str_replace('({$' . $key . '})', $item, $arrayMail['subject']);

					}
		
					$this->arrayData['subject'] = $arrayMail['subject'];
					$this->arrayData['body'] = $arrayMail['body'];
		
		
					unset($this->arrayData['tempate']);
					

					
					$this->arrayData['type'] = $arrayData['temp'];
					$this->arrayData['feedback'] = $arrayData['comment'];
					$this->arrayData['level'] = $arrayData['level'];
					
					$TakeFeedBack = $this->getModel('take/Feedback');
					$TakeFeedBack->addData($this->arrayData);
				}
			}
		}
	}
?>