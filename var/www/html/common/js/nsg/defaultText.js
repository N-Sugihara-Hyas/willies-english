objCSS = new Object();
$(document).ready(function(){
	for (key in objDefaultText){
		objCSS[key] = $('#i_' + key).css('color');
		outFocus(key);
	}
});


function outFocus(key){
	if (!$('#i_' + key).val()){
		$('#i_' + key).val(objDefaultText[key]);
		$('#i_' + key).css('color', '#CCCCCC');
	}
}

function onFocus(key){
		if (objDefaultText[key] == $('#i_' + key).val()){
			$('#i_' + key).css('color', objCSS[key]);
			$('#i_' + key).val('');
		}
}