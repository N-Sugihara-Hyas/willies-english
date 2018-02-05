/*
*	フォームのバリデートチェック
*/
function NsgDate(year, month, day, wareki){
var yearID = '#' + year;
var monthID = '#' + month;
var dayID = '#' + day;
var warekiID = '#' + wareki;

	/*
	*	現在の年から年齢の取得
	*/
	this.getAge = function (date){
		arrayDate = date.split('-');

		var DateYear = new Date();
		var year = DateYear.getYear();
		var month = DateYear.getMonth();
		var day = DateYear.getDate();
		var year2 = year - arrayDate[0];

		if (arrayDate[1] >= month){
			if (arrayDate[2] >= day){
				year2--;
			}
		}

		return year2;
	}
	/*
	*	西暦と和暦の比較データの取得
	*	@return 西暦と和暦のデータ
	*/
	this.changeEraFromJapan = function (){
		arrayJapanesList = this.getJapanesDate();

		wareki = $(warekiID).val();
		if (!arrayJapanesList[wareki]){return false;}
		arrayJapanes = arrayJapanesList[wareki];

		year = Number($(yearID).val());
		year = year + Number(arrayJapanes['baseYear']);

		month = Number($(monthID).val());
		day = Number($(dayID).val());

		date = year + '-' + month + '-' + day;
		bMatch = false;
		for (key in arrayJapanesList) {
			nengos = arrayJapanesList[key];

			if (nengos['start']){
				if (nengos['start'] <= date && date <= nengos['end']) {
					bMatch = true;
					break;
				}
			}
		}

		if (!bMatch){return false;}

		return date;
	}

	this.getJapanesDate = function(){
		arrayDate = new Array();

		arrayDate[1] = {nengo:'明治', start:'1868-09-08', end:'1912-07-29', baseYear:'1867'};
		arrayDate[2] = {nengo:'大正', start:'1912-07-30', end:'1926-12-24', baseYear:'1911'};
		arrayDate[3] = {nengo:'昭和', start:'1926-12-25', end:'1989-01-07', baseYear:'1925'};
		arrayDate[4] = {nengo:'平成', start:'1989-01-08', end:'9999-12-31', baseYear:'1988'};

		return arrayDate;
	}

}