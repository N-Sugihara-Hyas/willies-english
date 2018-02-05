<?php
/***********************************************************
*	ページ関連の制御
*/
class classPage{

	/***********************************************************
	*	コンストラクタ
	*/
	function classPage(){

	}

	/***********************************************************
	*	配列を元にページナビを付ける
	*/
	function changePageNavi($arrayData, $numOwnMax, $numNow){
		//該当件数の取得
		$arrayResult['numCount'] = count($arrayData);


		if (!$numNow){				//現ページが空の場合は0にする
			$numDataSeekMin = 0;
		}else{						//空では無い場合は設定する
			$numDataSeekMin = $numNow * $numOwnMax;
		}

		if (($numDataSeekMin + $numOwnMax) > $arrayResult['numCount']){
			$numDataSeekMax = $arrayResult['numCount'];
		}else{
			$numDataSeekMax = $numDataSeekMin + $numOwnMax;
		}

		//データの取得
		$arrayResult2 = $arrayData;

		$j = 0;
		for ($i = $numDataSeekMin; $i < $numDataSeekMax; $i++){
			$arrayResult['arrayList'][$j] = $arrayResult2[$i];
			$j++;
		}

		//下記は表示部
		if ($arrayResult['numCount']){$numDataSeekMin++;}

		//リスト表示用
		for ($i = 0; $i < $arrayResult['numCount'] / $numOwnMax; $i++){
			$arrayResult['arrayCountList'][$i]['numLink'] = $i;
			$arrayResult['arrayCountList'][$i]['numView'] = $i + 1;
		}
		
		if (count($arrayResult['arrayCountList']) <= 1){$arrayResult['arrayCountList'] = null;}

		//次へと前への数字の取得
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

		//何件～何件までの表示
		$arrayResult['numMin'] = $numDataSeekMin;
		$arrayResult['numMax'] = $numDataSeekMin + $numDataSeekMax - 1;

		if ($arrayResult['numMax'] < 0){$arrayResult['numMax'] = 0;}

		return $arrayResult;
	}
}

?>