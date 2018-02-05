/*
*	ダイアログ
*/
function ViewDialog(id, arrayButton){
this.arrayButton = arrayButton;
this.id = 'dialog' + id;
var self = this;

	this.show = function(message, fnc){
		this.fnc = fnc;

		$('body').append('<div id="' + this.id + 'Back" class="dialogBack"></div>');
		$('body').append('<div id="' + this.id + 'Front" class="dialogFront">' + message + '</div>');

		$('#' + this.id + 'Back').css('top', $('body').scrollTop() + 'px');
		$('#' + this.id + 'Front').css('top', $('body').scrollTop() + 'px');

		$('#' + this.id + 'Front').append('<div>');
		for (var key in this.arrayButton){
			$('#' + this.id + 'Front').append('<input type="button" value="' + this.arrayButton[key] + '" id="dialogButton' + key + '" class="buttonDialog" />');
			$('#dialogButton' + key).bind('click', key, this.onClickHandle);
		}
		$('#' + this.id + 'Front').append('</div>');

		$(window).scroll(function () {
			$('#' + self.id + 'Back').css('top', $('body').scrollTop() + 'px');
			$('#' + self.id + 'Front').css('top', $('body').scrollTop() + 'px');
		});

		$('#' + this.id + 'Back').bind('click', '', this.onBackHandle);
	}

	this.onClickHandle = function(event){
		self.clearDialog();
		self.fnc(event.data);
	}

	this.onBackHandle = function(){
		self.clearDialog();
	}

	this.clearDialog = function(){
		$('#' + self.id + 'Back').remove();
		$('#' + self.id + 'Front').remove();
	}

}

