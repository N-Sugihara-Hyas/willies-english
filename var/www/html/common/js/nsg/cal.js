/*
*	カレンダー
*/


function NsgCal(idStatic,targetStatic,isViewStatic){
var id=idStatic;
this.minYear;
var maxYear = 2020;
this.minMonth;
var maxMonth = 12;
this.minDay = 1;
var maxDay = 31;
var nowYear;
var nowMonth;
var targetID = targetStatic;
var isView;
var main;

	today=new Date();
	this.minYear = 2010;
	today=new Date();
	this.minMonth = 1;
	this.minDay = 1;

	if (!isViewStatic){
		isView = false;

		$('#' + targetID).click(function(event) {
			$('#' + id).css('display', 'block');
		});
	}else{
		isView = true;
	}


	/*
	 * カレンダーの取得
	 */
	this.setCal = function(year,month,day){

		today=new Date();
		 if (!year) var year=today.getFullYear();
		 if (!month) var month=today.getMonth();
		 else month--;
		 if (!day) var day=today.getDate();
		 var leap_year=false;
		 if ((year%4 == 0 && year%100 != 0) || (year%400 == 0)) leap_year=true;
		 lom=new Array(31,28+leap_year,31,30,31,30,31,31,30,31,30,31);
		 dow=new Array("日","月","火","水","木","金","土");
		 var days=0;
		 for (var i=0; i < month; i++) days+=lom[i];
		 var week=Math.floor((year*365.2425+days)%7);
		 var j=0;

		 selYear = '<select name="nowYear" id="' + id + 'nowYear">';
		 for (i=this.minYear; i <= maxYear; i++){
			 select = '';
			 if (i == year){select = ' selected'}

			 selYear+='<option value="' + i + '"' + select + '>' + i + '</option>';
		 }
		 selYear+= '</select>';

		 selMonth = '<select name="nowMonth" id="' + id + 'nowMonth">';

			var minMonthStatic = this.minMonth;
			if (this.minYear != year){minMonthStatic = 1;}

		 for (i=minMonthStatic; i <= maxMonth; i++){
			 select = '';
			 if (i == month+1){select = ' selected'}

			 selMonth+='<option value="' + i + '"' + select + '>' + i + '</option>';
		 }
		 selMonth+= '</select>';


		 isminMonth = false;

		 if (year <= this.minYear){
			 if (month+1 <= this.minMonth){
				 isminMonth = true;
			 }
		 }
		 var when=selYear+"年 "+selMonth+"月";
		 var calendar="<table class='calender'>\n";
		 calendar+="<caption id='calTitle'>"+when+"<\/caption>\n<tr>";
		 for (i=0; i < 7; i++) calendar+="<th><div style='width:20px;'>"+dow[i]+"</div><\/th>";
		 calendar+="<\/tr>\n<tr>";
		 for (i=0; i < week; i++,j++) calendar+="<td><div style='width:20px;'>&nbsp;</div><\/td>";
		 for (i=1; i <= lom[month]; i++) {
			 dayID = this.changeID(year, month+1, i);
			 calendar+="<td><div style='width:20px;'>";

			 if ((!isminMonth) || (i > this.minDay)){
				 if (!arrayCalendarLink[dayID]){
					 calendar+="<a href='javascript:void(0)' id='" + id + dayID + "'";
					 if (arrayCalendar[dayID]) calendar+=" class=\"special\"";
					 calendar+=">";
				 }
			 }

			 calendar+=i;

			 if ((!isminMonth) || (i > this.minDay)){
				 if (!arrayCalendarLink[dayID]){
					 calendar+="</a>";
				 }
			 }

			 calendar+="</div></td>";

			 j++;
			 if (j > 6) {
				 calendar+="<\/tr>\n<tr>";
				 j=0;
			 }
		 }
		 for (i=j; i > 6; i++) calendar+="<td><\/td>";
		 calendar+="<\/tr>\n<\/table>\n";


		 $('#' + id).html(calendar);

		 main = this;
		 $('#' + id + ' #' + id + 'nowYear').change(function(event) {
			 main.setChange();
		 });
		 $('#' + id + ' #' + id + 'nowMonth').change(function(event) {
			 main.setChange();
		 });

		 for (i=1; i <= lom[month]; i++) {
			 dayID = this.changeID(year, month+1, i);

			 main = this;
			 $('#' + id + dayID).click(this.onDay(main, dayID, year, month, i));
		 }
	}


	/*
	 * 年月が変わった瞬間
	 */
	this.setChange = function(){
		this.setCal($('#' + id + ' #' + id + 'nowYear').val(), $('#' + id + ' #' + id + 'nowMonth').val());
	}


	/*
	 * 年月日をIDに変換
	 */
	this.changeID = function(year,month,day){
		if (month < 10){month = '0' + month;}
		if (day < 10){day = '0' + day;}

		return year + month + day;
	}

	/*
	 * 年月日を表示用に変換
	 */
	this.changeDay = function(year,month,day){
		if (month < 10){month = '0' + month;}
		if (day < 10){day = '0' + day;}

		return year + '-' + month + '-' + day;
	}

	/*
	 * 特定の年月日での挙動変更のファイルに設定
	 */
	this.setSpecial = function(cal){
		calendar = cal;
	}

	/*
	 * 特定の年月日での挙動変更のファイル設定
	 */
	this.getSpecial = function(){
		var arrayCal = calendar.split(',');

		for (key in arrayCal){
			if (arrayCal[key]){
				arrayCalendar[arrayCal[key]] = 1;
			}
		}
	}

	/*
	 * 押された瞬間に実行
	 */
	this.onDay = function(main, dayID, year, month, day){
		return function(ev) {
			if (!isView){
				$('#' + id).css('display', 'none');
			}

			var date = main.changeDay(year, month+1, day)
			$('#' + targetID).val(date);

			onDay(dayID, date);
		}
	}

}
