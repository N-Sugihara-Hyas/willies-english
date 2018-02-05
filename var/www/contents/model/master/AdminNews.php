<?php

	addModel('ModelDB');

	/*
	*	サプリのクラス
	*/
	class MasterAdminNews extends ModelDB{
	var $tableName = 'master_admin_news';
	var $type = 0;			//一つ前のタイプ

		function addMailData($type, $body, $arrayMail=array(), $tID=0, $mID=0){
			$arrayData['subject'] = $type;
			$arrayCommit['message'] = $arrayData['body'] = $body;

			$arrayData['take_base_id'] = $tID;
			$arrayData['member_base_id'] = $mID;

			$this->commit($arrayData);


			//一部は、管理者が講師とやりとりするメールボックスにも入れる
			if ($type != $this->type){
				$TakeMessage = $this->getModel('take/Message');
				$arrayType = $TakeMessage->getFunctionData('AdminNewsType');
				$arrayCommit['from_id'] = -2;

				foreach ($this->arrayMail as $key => $item){
					$arrayType[$type]['value'] = str_replace('({$' . $key . '})', $item, $arrayType[$type]['value']);
				}

				$arrayCommit['member_base_id'] = $mID;
				
				//管理画面に送信
				if (($type == 51) || ($type == 4) || ($type == 6) || ($type == 9) || ($type == 15) || ($type == 19) || ($type == 21) || ($type == 44) || ($type == 43)){
					if ($type == 19){
						$arrayCommit['to_id'] = -1;
						$arrayCommit['from_id'] = -3;
					}else{
						$arrayCommit['to_id'] = -1;
					}

					$arrayCommit['subject'] = $arrayType[$type]['value'];

					$TakeMessage->commit($arrayCommit);
				}

				//講師に送信
				if (($type == 51) || ($type == 6) || ($type == 9) || ($type == 13) || ($type == 15) || ($type == 17) || ($type == 35) || ($type == 43)){
					$arrayCommit['to_id'] = $tID;
					$arrayCommit['subject'] = $arrayType[$type]['value'];

					$TakeMessage->commit($arrayCommit);
				}

				$this->type = $type;
			}
		}

		//コースの情報取得
		function getCourceData($cID, $csID, $cshID, $time, $tID){
			$TakeBase = $this->getModel('take/Base');
			$CourceBase = $this->getModel('cource/Base');
			$CourceStyle = $this->getModel('cource/Style');

			$this->arrayCourceStyle = $arrayCourceStyle = $CourceStyle->getDataUID($csID)->getData();
			$this->arrayData['courceStyleName'] = $arrayCourceStyle['courceStyleName'];
			$this->arrayData['courceStyleNameEnglish'] = $arrayCourceStyle['courceStyleNameEnglish'];
			$this->arrayMail['planType'] = $this->arrayData['planType'] = $arrayCourceStyle['styleType'];

			$arrayCourceBase = $CourceBase->getDataUID($cID)->getData();
			$this->arrayData['courceBaseName'] = $arrayCourceBase['courceName'];
			$this->arrayData['courceBaseNameEnglish'] = $arrayCourceBase['courceNameEnglish'];

			$arrayScheduleWeek = $this->getFunctionData('Schedule');

			if ($cshID){
				$this->arrayData['value'] = $arrayScheduleWeek[$cshID]['value'];
				$this->arrayData['valueEnglish'] = $arrayScheduleWeek[$cshID]['valueEnglish'];
			}

			$this->arrayData['memberTime'] = date('H:i', strtotime($time));

			$this->arrayTakeBase = $TakeBase->getDataUID($tID)->getData();

			$this->arrayData['nickname'] = $this->arrayTakeBase['nickname'];
			$this->arrayData['skypeID'] = $this->arrayTakeBase['skypeID'];

			
		}


		//体験時のメールの送付など
		function sendMail($arrayUser, $arrayData, $arrayCourceStyle, $arraySetting, $arrayDate, $mail1=5, $mail2=6, $arrayTakeBack=array()){
			$this->arrayData = $arrayUser;

			$this->addModelTool('Mail');

			$arrayWeek = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');



			//担任制か否かの判定
			$typ = 0;
			if ($arrayCourceStyle){
				if ($arrayCourceStyle['weekTake']){
					$type = 1;
				}
			}

			//ユーザーに送るようのメール用にデータの生成
			$this->arrayData = $arrayUser;

			if ($mail1 == 30){
				$this->arrayData['date'] = $arrayDate['date'];
				$this->arrayData['time'] = $arrayDate['time'];
				$this->arrayData['takeName'] = $arrayDate['takeName'];
			}

			//レッスンの基本情報取得
			$this->getCourceData($arrayData['cID'], $arrayCourceStyle['id'], $arrayData['cshID'], $arrayData['time'], $arrayData['tID']);

			$this->arrayData['date1'] = date('Y/m/d', strtotime($arrayDate[0])) . '(' . $arrayWeek[date('w', strtotime($arrayDate[0]))] . ') ' . $this->arrayData['memberTime'];

			if (isset($arrayDate[1])){
				$this->arrayData['date2'] = date('Y/m/d', strtotime($arrayDate[1])) . '(' . $arrayWeek[date('w', strtotime($arrayDate[1]))] . ') ' . $this->arrayData['memberTime'];
			}else{
				$this->arrayData['date2'] = '';
			}

			$arrayLevel = $this->getFunctionData('LevelChild');
			
			if (isset($this->arrayData['level'])){
				$this->arrayData['level'] = $arrayLevel[$this->arrayData['level']]['view'];
			}

			$this->arrayData['domain'] = $arraySetting['domain'];
			$this->mailSend($mail1, array($arrayUser['email']));


			//前講師と管理者に送るようのメール用にデータの生成
			$this->arrayData['student_ID'] = $arrayUser['id'];
			$this->arrayData['student_name'] = $arrayUser['memberNameSecoundEnglish'] . $arrayUser['memberNameFirstEnglish'];
			$this->arrayData['student_skypeID'] = $arrayUser['skypeID'];
			$this->arrayData['domain'] = $arraySetting['domain'];
			$arrayDataBack = $this->arrayData;

			if ($this->arrayData['level'] == 5){
				$this->arrayData['level'] = 1;
			}
			
			if ($arrayTakeBack){
				//前講師にもメール送信
				$this->mailSend(15, array($arrayTakeBack['email']), $arrayTakeBack['id']);
				$this->addMailData(15, $this->arrayMailSetting['body'], array($arrayTakeBack['email']), $arrayTakeBack['id'], $arrayUser['id']);
				$this->type = 0;
			}

			$this->arrayData = $arrayDataBack;

			//管理者にメール送信
			if ($mail1 != 30){
				$this->mailSend($mail2, array($arraySetting['email']));
			}

			//講師にもメール送信
			$this->mailSend($mail2, array($this->arrayTakeBase['email']), $this->arrayTakeBase['id']);

			//管理者のお知らせに追加
			$this->addMailData($mail2, $this->arrayMailSetting['body'], $this->arrayMailSetting, $this->arrayTakeBase['id'], $arrayUser['id']);


			//講師のお知らせに追加
			$this->addMailData($mail2,  $this->arrayMailSetting['body'], $this->arrayMailSetting, $this->arrayTakeBase['id'], $arrayUser['id']);

		}

		//本登録時のメールの送付など
		function sendMailPay($type, $arrayUser, $arrayCourceStyle=array()){
			$this->addModelTool('Mail');


			//本人にメール送信
			$this->arrayData = $arrayUser;
			$this->mailSend(8, array($arrayUser['email']));

			//本人のコミッショナーに反映
			$MasterCommunication = $this->getModel('master/Communication');
			$MasterCommunication->addDataType($arrayUser['id'], 0, $this->arrayMailSetting['body']);


			//レッスンの基本情報取得
			$this->getCourceData($arrayUser['cource_base_id'], $arrayUser['cource_style_id'], $arrayUser['cource_schedule_id'], $arrayUser['timeStart'], $arrayUser['take_base_id']);

			//管理者に送信するメール
			$this->arrayData['student_ID'] = $arrayUser['id'];
			$this->arrayData['student_name'] = $arrayUser['memberNameSecoundEnglish'] . $arrayUser['memberNameFirstEnglish'];
			$this->arrayData['student_skypeID'] = $arrayUser['skypeID'];


			if ($this->arrayCourceStyle['weekTake']){
				$mailType = 9;
			}else{
				$mailType = 44;
			}

			$this->mailSend($mailType, array($this->arraySetting['email']));

			//担当講師にもメール
			if ($this->arrayCourceStyle['weekTake']){
				$this->mailSend($mailType, array($this->arrayTakeBase['email']), $this->arrayTakeBase['id']);
			}

			//管理者のお知らせに追加
			$this->addMailData($mailType, $this->arrayMailSetting['body'], $this->arrayMailSetting, $this->arrayTakeBase['id'], $arrayUser['id']);

			//講師のお知らせに追加
			if ($this->arrayCourceStyle['weekTake']){
				$this->addMailData($mailType, $this->arrayMailSetting['body'], $this->arrayMailSetting, $this->arrayTakeBase['id'], $arrayUser['id']);
			}
		}

		//レッスンキャンセル時のメールの送付など
		function sendMailCancel($arrayUser, $arrayReserve){
			$this->addModelTool('Mail');

			$this->arrayData = $arrayReserve;

			//基本情報の取得
			$this->getCourceData($arrayUser['cource_base_id'], $arrayUser['cource_style_id'], 0, $arrayReserve['timeStart'], $arrayReserve['take_base_id']);

			$this->arrayData['time'] = $arrayReserve['timeStart'];
			$this->arrayData['takeName'] = $arrayReserve['nickname'];
			$this->arrayData['domain'] = $this->arraySetting['domain'];

			foreach ($arrayUser as $key => $item){
				$this->arrayData[$key] = $item;
			}

			//本人にメール送付
			$this->mailSend(10, array($arrayUser['email']));

			//本人のコミッショナーに反映
			$MasterCommunication = $this->getModel('master/Communication');
			$MasterCommunication->addDataType($arrayUser['id'], 0, $this->arrayMailSetting['body']);

			//管理者にメール送付
			$this->arrayData['student_ID'] = $arrayUser['id'];
			$this->arrayData['student_name'] = $arrayUser['memberNameSecoundEnglish'] . $arrayUser['memberNameFirstEnglish'];
			$this->arrayData['student_skypeID'] = $arrayUser['skypeID'];

			//管理者のお知らせに追加
			$this->addMailData(11, $this->arrayMailSetting['body'], $this->arrayMailSetting, $this->arrayTakeBase['id'], $arrayUser['id']);

			//講師のお知らせに追加
			$this->addMailData(11, $this->arrayMailSetting['body'], $this->arrayMailSetting, $this->arrayTakeBase['id'], $arrayUser['id']);

		}

		//振替え時のメールの送付など
		function sendMailReturn($arrayUser, $arrayDate){
			$this->addModelTool('Mail');

			$this->arrayData = $arrayDate;
			$this->arrayData = array_merge($this->arrayData, $arrayUser);

			//基本情報の取得
			$this->getCourceData($arrayUser['cource_base_id'], $arrayUser['cource_style_id'], 0, $arrayDate['time'], $arrayDate['tID']);


			$this->arrayData['takeName'] = $this->arrayTakeBase['nickname'];
			$this->arrayData['skypeID'] = $this->arrayTakeBase['skypeID'];

			//本人にメール送付
			$this->mailSend(12, array($arrayUser['email']));

			//本人のコミッショナーに反映
			$MasterCommunication = $this->getModel('master/Communication');
			$MasterCommunication->addDataType($arrayUser['id'], 0, $this->arrayMailSetting['body']);

			//管理者にメール送付
			$this->arrayData['student_ID'] = $arrayUser['id'];
			$this->arrayData['student_name'] = $arrayUser['memberNameSecoundEnglish'] . $arrayUser['memberNameFirstEnglish'];
			$this->arrayData['student_skypeID'] = $arrayUser['skypeID'];

			//講師にもメール送信
			$this->mailSend(13, array($this->arrayTakeBase['email']));

			//管理者のお知らせに追加
			$this->addMailData(13, $this->arrayMailSetting['body'], $this->arrayMailSetting, $this->arrayTakeBase['id'], $arrayUser['id']);

			//講師にもお知らせ追加
			$this->addMailData(13, $this->arrayMailSetting['body'], $this->arrayMailSetting, $this->arrayTakeBase['id'], $arrayUser['id']);

		}

		//FeedBacknoメールの送付など
		function sendMailFeedBack($arrayUser, $arrayData){
			$this->addModelTool('Mail');

			$this->arrayMail = $arrayData;

			//管理者にメール送付
			$this->arrayData['student_ID'] = $arrayUser['id'];
			$this->arrayData['student_name'] = $arrayUser['memberNameSecoundEnglish'] . $arrayUser['memberNameFirstEnglish'];
			$this->arrayData['student_skypeID'] = $arrayUser['skypeID'];

			$TakeBase = $this->getModel('take/Base');
			$arrayTake = $TakeBase->getDataUID($arrayUser['take_base_id'])->getData();
			$this->arrayData['nickname'] = $arrayTake['nickname'];

			//講師にもメール送信
			$this->mailSend(17, array($arrayTake['email']));

			//管理者のお知らせに追加
			$this->addMailData(17, $this->arrayMailSetting['body'], $this->arrayMailSetting, $arrayTake['id'], $arrayUser['id']);

			//講師にもお知らせ追加
			$this->addMailData(17, $this->arrayMailSetting['body'], $this->arrayMailSetting, $arrayTake['id'], $arrayUser['id']);
		}

		//体験レッスンがある場合は講師に送付
		function sendMailTrial($arrayData){
			$this->addModelTool('Mail');

			$this->arrayMail = $arrayData;

			$TakeBase = $this->getModel('take/Base');
			$arrayTake = $TakeBase->getDataUID($arrayData['take_base_id'])->getData();
			$this->arrayData['nickname'] = $arrayTake['nickname'];

			//講師にもメール送信
			$this->mailSend(35, array($arrayTake['email']));

			//講師にもお知らせ追加
			$this->addMailData(35, $this->arrayMailSetting['body'], $this->arrayMailSetting, $arrayTake['id']);
		}

	}

?>