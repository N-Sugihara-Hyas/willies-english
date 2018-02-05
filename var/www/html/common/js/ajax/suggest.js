/*
*	データを読み込みページ表示させるための処理
*/
function AjaxSuggest(id, tID, url){
var self = this;
this.html = '';
this.id = id;
this.count = 0;
this.page = -1;
this.url = url;
this.tID = tID;
this.max = 0;
this.arrayPage = new Array();

	AjaxServer.apply(this,new Array(url));

	//情報の読み込み
	this.load = function(keyword){
		self.fnc = self.complateDataHandle;
		self.dataType = 'json';
		self.data = {keyword:keyword};

		self.access();
	}

	this.complateDataHandle = function(data){
		$(self.id).css('display', 'block');

		var html = '';
		$(this.id).html('');

		for (var key in data['arrayItem']){
			var divID = id + '_' + self.count;
			html = '<div id="' + divID.replace('#', '') + '" class="pointer">' + self.html + '</div>';
			$(this.id).append(html);

			for (var key2 in data['arrayItem'][key]){

				if (key2){
					$(divID).find('.' + key2).html(data['arrayItem'][key][key2]);
				}
			}

			$(divID).bind('click', '', self.onClickHandle);
			self.count++;
		}

		complateSuggestHandle(data);
	}

	this.onClickHandle = function(event){
		var html = $(event.target).html();

		$(self.tID).val(html);
		$(self.id).css('display', 'none');
	}

	this.changeText = function(event){
		self.load($(self.tID).val());
	}

	$(this.tID).bind('keyup','', this.changeText);

}