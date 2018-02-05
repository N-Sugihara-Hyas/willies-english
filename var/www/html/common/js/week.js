function getNextWeekFirst(text, time){
	var arrayWeek = new Array('日', '月', '火', '水', '木', '金', '土');
	var arrayText = text.split('・');
	var arrayResult = new Object();


	var date=new Date(); 
	for (i = 1; i <= 7; i++){
		var dateWeek=new Date((time + (3600 * 24 * i)) * 1000);
		var week = dateWeek.getDay();
	
		for (key in arrayText){
			if (arrayText[key] == arrayWeek[week]){

				var year = (dateWeek.getYear() + 1900) + '-';
				var month = (dateWeek.getMonth() + 1) + '-';
				var day = dateWeek.getDate();


				arrayResult[year + month + day] = year + month + day + '(' + arrayWeek[week] + ')';
			}
		}
	}

	return arrayResult;
}
