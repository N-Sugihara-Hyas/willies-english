/*
* 宿題の資材の取得処理
*/
function getHomeworkBook(){
	$.ajax({
		url : '/api/homeworkbook/?type=1&cource_base_id=' + $('#id_cource_base_id').val() + '&level=' + $('#id_level').val(),
		cache: false,
		type : "post",
		success: complateHomeworkBookGCCHandle
	});

	$.ajax({
		url : '/api/homeworkbook/?type=2&cource_base_id=' + $('#id_cource_base_id').val() + '&level=' + $('#id_level').val(),
		cache: false,
		type : "post",
		success: complateHomeworkBookRLCHandle
	});

}

function complateHomeworkBookGCCHandle(data){
	var arrayData = data.split("\n");

	$('#id_gcc').children().remove();

	for (key in arrayData){
		var arrayDataOwn = arrayData[key].split(",");

		if (arrayDataOwn){
			$('#id_gcc').append($('<option>').attr({ value: arrayDataOwn[0] }).text(arrayDataOwn[1]));
		}
	}
}


function complateHomeworkBookRLCHandle(data){
	var arrayData = data.split("\n");

	$('#id_rlc').children().remove();

	for (key in arrayData){
		var arrayDataOwn = arrayData[key].split(",");

		if (arrayDataOwn){
			$('#id_rlc').append($('<option>').attr({ value: arrayDataOwn[0] }).text(arrayDataOwn[1]));
		}
	}
}
