
function areaZipType1(zipID, zipID2,areaID,cityID,townID, api){

	var zip1 = $('#' + zipID).val();
	var zip2 = $('#' + zipID2).val();


	area(zip1 + zip2, areaID,cityID,townID, api);
}

function area(zip, areaID, cityID, townID, api){
		if (!zip){
			alert('郵便番号を入力して下さい');
		}else{
			_areaID = areaID;
			_cityID = cityID;
			_townID = townID;

			$.ajax({
					url : api + zip,
					cache: false,
					type : "post",
					//context : my,
					success: complateAreaHandle
			});
		}
}

function complateAreaHandle(data){
	$('#' + _areaID).val('');
	$('#' + _cityID).val('');
	$('#' + _townID).val('');

	data = $.parseJSON(data);

	if (data.setting_area2_id){
		$('#' + _areaID).val($('#' + _areaID).val() + data.setting_area2_id);
	}

	if (data.setting_city_id){
		$('#' + _cityID).val($('#' + _cityID).val() + data.setting_city_id);
	}

	complateAreaZipHandle();
}