function onView(id){
	if ($('#tab' + id).css('display') == 'none'){
		$('#tab' + id).css('display', '');
	}else{
		$('#tab' + id).css('display', 'none');
	}
}

function onStar(id){
	if ($('#star' + id).text() == '★'){
		$('#star' + id).text('☆');
	}else{
		$('#star' + id).text('★');
	}

	$.ajax({
		url : '/card/api/ok/' + id + '/',
		cache: false,
		type : "post",
		success: complateEndHandle
	});
}

function complateEndHandle(data){

}
