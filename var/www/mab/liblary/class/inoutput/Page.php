<?php
/***********************************************************
*	�y�[�W�֘A�̐���
*/
class classPage{

	/***********************************************************
	*	�R���X�g���N�^
	*/
	function classPage(){

	}

	/***********************************************************
	*	�z������Ƀy�[�W�i�r��t����
	*/
	function changePageNavi($arrayData, $numOwnMax, $numNow){
		//�Y�������̎擾
		$arrayResult['numCount'] = count($arrayData);


		if (!$numNow){				//���y�[�W����̏ꍇ��0�ɂ���
			$numDataSeekMin = 0;
		}else{						//��ł͖����ꍇ�͐ݒ肷��
			$numDataSeekMin = $numNow * $numOwnMax;
		}

		if (($numDataSeekMin + $numOwnMax) > $arrayResult['numCount']){
			$numDataSeekMax = $arrayResult['numCount'];
		}else{
			$numDataSeekMax = $numDataSeekMin + $numOwnMax;
		}

		//�f�[�^�̎擾
		$arrayResult2 = $arrayData;

		$j = 0;
		for ($i = $numDataSeekMin; $i < $numDataSeekMax; $i++){
			$arrayResult['arrayList'][$j] = $arrayResult2[$i];
			$j++;
		}

		//���L�͕\����
		if ($arrayResult['numCount']){$numDataSeekMin++;}

		//���X�g�\���p
		for ($i = 0; $i < $arrayResult['numCount'] / $numOwnMax; $i++){
			$arrayResult['arrayCountList'][$i]['numLink'] = $i;
			$arrayResult['arrayCountList'][$i]['numView'] = $i + 1;
		}
		
		if (count($arrayResult['arrayCountList']) <= 1){$arrayResult['arrayCountList'] = null;}

		//���ւƑO�ւ̐����̎擾
		if ($arrayResult['numCount'] > $numOwnMax){
			$arrayResult['numNext'] = $numNow + 1;
		}
		if (($arrayResult['numNext'] * $numOwnMax) >= $arrayResult['numCount']){
			$arrayResult['numNext'] = '';
		}

		$arrayResult['numNow'] = $numNow;

		$arrayResult['numBack'] = '';
		if ($numNow >= 0){
			$arrayResult['numBack'] = $numNow - 1;
		}

		//�����`�����܂ł̕\��
		$arrayResult['numMin'] = $numDataSeekMin;
		$arrayResult['numMax'] = $numDataSeekMin + $numDataSeekMax - 1;

		if ($arrayResult['numMax'] < 0){$arrayResult['numMax'] = 0;}

		return $arrayResult;
	}
}

?>