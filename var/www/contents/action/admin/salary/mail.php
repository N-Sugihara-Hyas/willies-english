<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		$this->addModel(array('take/Salary', 'cource/Style'));

		//共通処理
		$this->getCommon();

		list($dateStart, $dateEnd) = $this->TakeSalary->getDate();
		
		$arrayBody = json_decode_mab($this->arrayAll['body'], true);		
		$arrayDataType5 = json_decode($this->arrayAll['arrayDataType5'], true);
		
		
		$count4 = $arrayBody['bcount']; 

		$trial = '';		

		foreach ($arrayBody['arrayTrial'] as $objMember){
			$trial.= $objMember['member_base_id'] . '(' . $objMember['date'] . '),';
		}
				
		$total = 0;
		
		$subject = $arrayBody['objTake']['nickname'] . ':  WiLLies English:   Salary for this month';
		
		$arrayType = $this->CourceStyle->getBasicStyle();
		$rate = '';
		foreach ($arrayType as $key => $value){
			if (isset($value['time'])){
				$rate.= ' - Class ' . $key . ' Rate: ' .$arrayBody['arrayRate'][$key] .' peso' . "\n";
			}
		}
		$counter = '';
		foreach ($arrayType as $key => $value){
			if (isset($value['time'])){
				$counter.= ' - Class ' . $key . ' Rate: ' .$arrayBody['arrayCounter'][$key] .' lesson' . "\n";
			}
		}
 
		$text = '
Thanks for your work.

This is the salary for this month:' . $dateStart . ' - ' . $dateEnd . '

Thank you!

-------------------------------------------------------------------------------------------------------------------------------------
Total Salary: ' . number_format($arrayBody['arrayTotal']['total']) . ' peso

Detail...
1. # of Days on this month
 - # of days on Weekday:  ' . $arrayBody['weekday']  . ' days
 - # of days on Weekend (if you work on weekend): ' . $arrayBody['weekend'] . ' days


2. Your shift
 - Weekday Shift: ' . $arrayBody['weekdayHr'] . ' hrs
 - Weekend Shift: ' . $arrayBody['weekendHr'] . ' hrs


3. Your Salary Rate
 - Basic Salary Rate: ' . $arrayBody['arrayRate']['BasicSalaryRate'] .' peso

' . $rate .

' - New Student Bonus: ' . $arrayBody['arrayRate']['BonusNewStudent'] .' peso
 - Internet Allowance: ' . $arrayBody['arrayRate']['InternetAllowance'] .' peso
 - Referral Bonus: ' . $arrayBody['arrayRate']['ReferralBonus'] .' peso
 
 4. # of Class You had
'
	. $counter . 
'
 - Other:  ' . $arrayBody['arrayCounter']['Other'] . '
 - Additional Work:  ' . $arrayBody['arrayCounter']['AdditionalWork'] . '
 - Absence:  ' . $arrayBody['arrayCounter']['Absence'] . '
 - Absence %:  ' . $arrayBody['icount'] . '%


5. New Student Bonus
 - New Student Bonus: ' . number_format($arrayBody['ntotal']) . ' peso
 - Student ID: ' . $arrayBody['nmember'] . '

6. Internet Allowance
 - Internet Allowance: ' . $arrayBody['ipeso'] .' peso
 - % of your absence: ' . getVar($arrayBody, 'icount') . '%

7. Referral Bonus
 - Referral Bonus: ' . number_format($arrayBody['rtotal']) . ' peso

8. Others
 - Others: ' . number_format($arrayBody['ocount']) .' peso
 - Memo:  ' . $arrayBody['memo'] . '


 ';

 	$this->set('arrayBody', $arrayBody); 
 	$this->set('subject', $subject); 
 	$this->set('body', $text);


?>