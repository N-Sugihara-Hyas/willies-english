countCheck = 0;
objCount = new Object();

/*
 *	現在のチェック数の設定
 */
function setCheckCount(count){
	countCheck = count;
}

/*
 *	現在のチェック数の取得
 */
function getCheckCount(){
	return countCheck;
}

/*
 * 指定したクラスで全選択と全解除の実装
 */
function checkSelectAll(checkButton, checkTarget){
	$('input.' + checkTarget + ':checkbox').prop('checked', $('#' + checkButton).is(':checked'));
}


/*
 * セッションに指定したチェックボックスの保存(クラスで指定)
 */
function setCheckTarget(action, checkButton, checkTarget){
	$('.' + checkTarget).each(function() {
		setCheck(action, $(this).attr('id').replace(/uid/, ''));
	});
}

/*
 * セッションに指定したチェックボックスの保存
 */
function setCheck(action, id, manual){
	if (manual != undefined){
		check = manual;
	}else{
		check = 0;
		if ($('#uid' + id).attr('checked')){
			check = 1;
			countCheck++;
		}else{
			countCheck--;
		}
	}

	$.ajax({
		url : action + '&id=' + id + '&type=' + check,
		cache: false,
		type : "post",
		success: complateCheckHandle
	});

	$('#checkCount').text(getCheckCount());

}

function complateCheckHandle(data){
}