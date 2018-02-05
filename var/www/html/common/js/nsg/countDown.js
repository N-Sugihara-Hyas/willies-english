objCount = new Object();

function setCountDown(id, count, target){
	objCount[id] = count;

	str = $('#' + target).val();

	$('#' + target).keyup(function(e){
		str = $('#' + target).val();
		$('#' + id).text(objCount[id] - str.length);
	});

	$('#' + id).text(objCount[id] - str.length);

}
