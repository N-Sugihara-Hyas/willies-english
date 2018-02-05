_selectID = false;
_fnc = '';

function getAjaxSelect(api, data, selectID){
	_selectID = selectID;

	ajax(api, data, '');
}

function ajax(api, data, fnc){
	if (fnc){
		if ($.isFunction(fnc)){
			_fnc = fnc;
		}else{
			_fnc = complateAjaxEnd;
		}
	}


	$.ajax({
			url : api,
			cache: false,
			type : "post",
			data:data,
			//context : my,
			success: complateAjaxHandle
	});


}




function complateAjaxHandle(data){
	if (_selectID){
		setSelect(data);
	}


	_fnc(data);
}

function setSelect(data){
	arrayData = data.split("\n");

	$('#' + _selectID + ' > option').remove();


	for (key in arrayData){
		if (arrayData[key]){
			arrayData2 = arrayData[key].split(",");

			$('#' + _selectID).append($('<option>').html(arrayData2[1]).val(arrayData2[0]));
		}
	}



}
