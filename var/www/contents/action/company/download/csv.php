<?php
/*
*	トピックスリストの読み込み
*/

		//共通処理
		$this->getCommon();

		$this->addLiblary(array('inoutput/Date'));
		$this->addModel(array('card/Base', 'company/Member', 'ext/Homework'));
		
		
		if ($this->arrayAll['date'] > 12){
			$this->arrayAll['date'] = 12;
		}
				
		$InoutputDate = new InoutputDate();
		
		$date =  $InoutputDate->getDateNext(date('Y-m-d'), 'm', $this->arrayAll['date'] * -1);
				
		//会員の情報取得
		$this->CompanyMember->joinMemberBase();
		$dbGet = $this->CompanyMember->getMemberAll($this->arrayUser['id']);

		header("Content-Type:text/html; charset=SJIS");
		
		header("Cache-Control: public");
		header("Pragma: public");
		header("Content-Type: application/octet-stream");
		header('Content-Disposition: attachment; filename="ダウンロード.csv"');
		
		
		while ($objData = $dbGet->getData()){
			
			$this->ExtHomework->addQuery('member_base_id', $objData['member_base_id']);
			$this->ExtHomework->addQuery('date >=', $date);
			$this->ExtHomework->joinTakeBase();
			$dbGet2 = $this->ExtHomework->getData();

						
			while ($objHomework = $dbGet2->getData()){
				echo mb_convert_encoding($objData['id'] . '.' . $objData['memberNameSecound'] . ' ' . $objData['memberNameFirst'] . ',', 'SJIS', 'UTF-8');

				
				$objCard = $this->CardBase->getTarget($objHomework)->getData();

				echo  $objHomework['date'] . ',' . $objHomework['nickname'] . ',';

				echo '"';
				
				$str = '';				
				if ($objCard['free']){
					$str.= $objCard['free'];
				}
				
					$str.= '- GCC: ' . $objHomework['gcc'];
					$str.= '- RLC: ' . $objHomework['rlc'];
					$str.= 'Follow-up questions:';
					
					if (isset($objHomework['followup'])){
						$str.= $objHomework['followup'];
					}
				
				//$str = str_replace(PHP_EOL, '', $str);
				$str = str_replace('"', '”', $str);
				$str = str_replace(',', '，', $str);

				$str.= '"';
				
				echo mb_convert_encoding($str, 'SJIS', 'UTF-8') . "\n";
			}			
		}
			exit();

?>