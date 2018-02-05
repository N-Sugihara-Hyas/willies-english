$(document).ready(function(){
	scroll();
});

$(window).resize(function(){
	scroll();
});

function scroll(){
	var width = $('#wrap').width() - $('#contentsLeft').width();

	$('#contentsMain').width(width - 100);
}