<?php
/*
*	数字関連の処理
*/
class InoutputNumber{
var $numRand;

	/*
	*	乱数の取得
	*	@params 乱数を取得できる最大値
	*/
	function getRandom($numArea){
		srand((double)microtime()*1000000);
		$this->numRand=round(rand(1, $numArea)) - 1;

		return $this->numRand;
	}

	/***********************************************************
	*	100%中、指定のパーセントで抽選
	***********************************************************/
	function check100Random($numHit){
		$this->getRandom(100);

		if ($numHit >= $this->numRand){
			return true;
		}else{
			return false;
		}
	}

	/***********************************************************
	*	現在日、生年月日から年齢の取得
	***********************************************************/
	function getBirthAge($dateBirth){
		return intval((date('Ymd') - $dateBirth) / 10000);
	}

	/*
	*	消費税の取得
	*/
	function getTax($price){
		$result = $price * 0.05;

		return $result;
	}

}

?>