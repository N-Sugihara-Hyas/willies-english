/*
*	フォームのバリデートチェック
*/

function ShowNowLoading(id){

this.id = id;

	this.show = function(){
		$(this.id).css('display', 'block');

		if ($(window).height() < $('body').height() ){
			$(this.id).css('height', $('body').height());
		}else{
			$(this.id).css('height', $(window).height());
		}
	}

	this.hidden = function(){
		$(this.id).css('display', 'none');
	}

}
