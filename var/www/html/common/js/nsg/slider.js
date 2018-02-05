function Slider(idStatic, max, first, ownSize, isViewOnry){
var id = idStatic;
var drag = false;
var posStart = $('#' + id).offset().left;
var posEnd = posStart + $('.backSlider').width() - $('#' + id).width();

if (ownSize){
	var own = ownSize;
}else{
	var own = (posEnd - posStart) / max;
}

var now = 1;


	if (first){
		now = first * own;
		$('#' + id).css('left', now);
	}

	if (!isViewOnry){
		$('#' + id).mousedown(function(){
			drag = true;
		});
	}

	$('body').mousemove(function(mouse){
		if (drag){
			if (posStart < mouse.clientX){
				if (posEnd > mouse.clientX){
					now = Math.floor((mouse.clientX - posStart) / own);
					var pos = now * own;

					$('#' + id).css('left', pos);
				}else{
					now = max;
					$('#' + id).css('left', own * max);
				}
			}else{
				now = 0;
				$('#' + id).css('left', 0);
			}
		
			$('#' + id + '_value').val(now);
		}
	});

	$('body').mouseup(function(){
		if (drag){
			drag = false;
		}
	});

}