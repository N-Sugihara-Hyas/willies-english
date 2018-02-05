<?php

/*
 * 日付関連
 */
class InoutputDate{

	/*
	 * 日の取得
	 * @return 日の情報を配列で返す
	 */
	function getArrayDay(){
		return array('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
	}

	/*
	 * 月の取得
	 * @return 月の情報を配列で返す
	 */
	function getArrayMonth(){
		return array('1','2','3','4','5','6','7','8','9','10','11','12');
	}


	/*
	 * 曜日の取得
	 * @return 曜日の情報を配列で返す
	 */
	function getArrayWeek(){
		return array('日','月','火','水','木','金','土','日');
	}

	function getWeek($w){
		$arrayWeek = InoutputDate::getArrayWeek();
		return $arrayWeek[$w];
	}

	/*
	 * 月末の取得
	 * @params $year 年 $month 月
	* @return 指定された月末の情報を配列で返す
	*/
	function getArrayMonthLast($year, $month){
		$arrayMonth = array('31','28','31','30','31','30','31','31','30','31','30','31');
		$monthLast = $arrayMonth[$month - 1];

		if ($month == 2){
			if ($this->isLeap($year)){
				$monthLast++;
			}
		}

		return $monthLast;
	}

	/*
	 * checkdate 関数を使用して閏年か調べる
	*/
	function isLeap($year){
		return checkdate(2, 29, $year);
	}

	/*
	 * 年(未来)の取得
	 * @params $year 何年後までを取得するか
	 * @return 年の情報を配列で返す
	 */
	function getArrayNowYear($year){
		$nowYear = date('Y');
		$maxYear = $nowYear + $year;

		$key=0;
		for ($i = $nowYear; $i <= $maxYear; $i++){
			$arrayDate[$key] = $i;
			$key++;
		}

		return $arrayDate;
	}

	/*
	 * 年(過去)の取得
	 * @params $year 何年前までを取得するか
	 * @return 年の情報を配列で返す
	 */
	function getArrayNowYearFront($year){
		$nowYear = date('Y');
		$maxYear = $nowYear - $year;

		$key=0;
		for ($i = $nowYear; $i >= $maxYear; $i--){
			$arrayDate[$key] = $i;
			$key++;
		}

		return $arrayDate;
	}


	/*
	 * 指定した月のカレンダー情報の取得
	 * @params month 取得するカレンダの月
	 * @return 指定した月のカレンダー情報
	 */
	function getCalMonth($year, $month){
		$arrayCal['dayLast'] = date('t',mktime(0,0,0,$month,1,$year) );
		$arrayCal['w'] = date('w', strtotime($year . '-' . $month . '-01 00:00:00'));

		return $arrayCal;
	}


	/*
	 * 日にち、時間、分と用途に合わせて取得
	 * @params $date 日時 $mode 0は前、1は後を取得
	 * @return 結果を返す
	 */
	function getDateType($date, $mode=0){

		if ($date){
			if ($mode == 1){
				$time = strtotime($date) - time();
			}else{
				$time = time() - strtotime($date);
			}

			if ($time > 60 * 60 * 24){
				$result = intval($time / (60 * 60 * 24));
				$result.= '日';
			}else if($time > 60 * 60){
				$result = intval($time / (60 * 60));
				$result.= '時間';
			}else if($time > 60){
				$result = intval($time / 60);
				$result.= '分';
			}else{
				$result = intval($time);
				$result.= '秒';
			}
		}else{
			$result = '-';
		}

		if ($result > 0){
			return $result;
		}

		return '-';
	}


	/*
	*	西暦と和暦の比較データの取得
	*	@return 西暦と和暦のデータ
	*/
	function getJapanesDate(){
		$this->arrayJapan = array(
				array(),
				array('nengo' => '明治', 'start' => '1868-09-08', 'end' => '1912-07-29', 'baseYear' => 1867),
				array('nengo' => '大正', 'start' => '1912-07-30', 'end' => '1926-12-24', 'baseYear' => 1911),
				array('nengo' => '昭和', 'start' => '1926-12-25', 'end' => '1989-01-07', 'baseYear' => 1925),
				array('nengo' => '平成', 'start' => '1989-01-08', 'end' => '9999-12-31', 'baseYear' => 1988),
		);

		return $this->arrayJapan;
	}

	/*
	*	和暦を西暦に変換
	*	@params $type 和暦のタイプ(1：明治,2:大正,3:昭和,4:平成) $date 和暦の年月日
	*	@return 西暦
	*/
	function changeJapaneseFromEra($type, $date){
		$arrayJapanesList = $this->getJapanesDate();

		list($wareki, $month, $day) = explode('-', $date);

		if (!isset($arrayJapanesList[$type])){return false;}

		$arrayJapanes = $arrayJapanesList[$type];
		$year = $wareki + getVar($arrayJapanes, 'baseYear');

		$date = "$year-$month-$day";
		$bMatch = FALSE;
		foreach ($arrayJapanesList as $nengos) {
			if (isset($nengos['start']) ){
				if ($nengos['start'] <= $date && $date <= $nengos['end']) {
					$bMatch = TRUE;
					break;
				}
			}
		}

		if (!$bMatch){return false;}

		return $date;
	}


	/*
	*	西暦を和暦に変換
	*	@params $date 西暦の年月日
	*	@return 和暦
	*/
	function changeEraFromJapanese($date){
		$arrayJapanesList = $this->getJapanesDate();

		if (strlen($date) < 5){
			return false;
		}

		list($year, $month, $day) = explode('-', $date);

		foreach ($arrayJapanesList as $key => $nengos) {
			if (isset($nengos['start']) ){
				if ($nengos['start'] <= $date && $date <= $nengos['end']) {
					list($year2, $month2, $day2) = explode('-', $nengos['start']);

					$dateResult = ($year - $nengos['baseYear']) . '-' .  $month . '-' . $day;

					$type = $key;
					break;
				}
			}
		}

		return array($type, $dateResult);
	}

	/*
	 *	日にちか、月か、年を進めたものを取得
	*	@params $date 日付, $type タイプ $count 進める数
	*	@return 進めた日付
	*/
	function getDateNext($date, $type, $count){
		list($y,$m,$d) = explode('-', $date);

		if ($type == 'm'){

			$m+=$count;
			if ($m > 12){
				$y++;
				$m = $m - 12;
			}

			if ($m < 10){
				$m = '0' . $m;
			}
		}

		//月末判定を入れる
		if ($d >= 28){
			$dayLast = $this->getArrayMonthLast($y, $m);
			$d = $dayLast;
		}

		return $y . '-' . $m . '-' . $d;
	}

	/*
	 * 誕生日(西暦)から年齢を計算
	 * @params $date 西暦
	 * @return 年齢
	 */
	function changeDateAge($date){
		$now = date('Ymd');
		$date = str_replace('-','',  $date);
		return floor( ($now-$date) / 10000 );
	}

	/*
	*	次の該当の曜日の日付を取得
	*	@params $w 曜日 $date 現在の日付
	*	@return 次の曜日の日付
	*/
	function getNextWeekDate($w, $date){
		$i = 1;
		while (1){
			$time = strtotime($date) + (60 * 60 * 24 * $i);
			$wTo = date('w', $time);

			if ($w == $wTo){
				return date('Y-m-d', $time);
			}
			$i++;
		}
	}

	/*
	*	第何週目かの取得
	*	@params $date 日付
	*	@return 第何週目か
	*/
	function getWeekCount($date) {
		$time = strtotime($date);

	  // 当日の日付
	  $today_num    = date('j', $time);

	  // 当日の曜日キー
	  $today_key    = date('w', $time);

	  $firstday_key    = date('w', mktime(0, 0, 0, date('n', $time), 1));

	  if((int)($today_num % 7) != 0) {
	      $week    = (int)($today_num / 7) + 1;
	  } else {
	      $week    = (int)($today_num / 7);
	  }

	  if(($firstday_key != 0) && ($firstday_key <= $today_key)) {
	      $week--;
	  }
	  return $week;
	}


}
?>