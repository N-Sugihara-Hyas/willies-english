/*
*	データを読み込みページ表示させるための処理
*/
function AjaxMore(id, bID, url){
var self = this;
this.html = '';
this.id = id;
this.count = 0;
this.page = -1;
this.url = url;
this.bID = bID;
this.max = 0;
this.isSlide = false;
this.widthSlide = 0;
this.slideID = '';
this.arrayPage = new Array();

	AjaxServer.apply(this,new Array(url));

	//情報の読み込み
	this.load = function(page){
		if (!page){page = 1;}

		self.page+=page;


		if (self.arrayPage[self.page]){
			self.moveSlideHandle();
		}else{
			self.arrayPage[self.page] = true;

			self.fnc = self.complateDataHandle;
			self.dataType = 'json';
			self.data = {page:self.page};

			self.access();
		}
	}

	this.complateDataHandle = function(data){
		self.max = data['header']['max'];

		if (self.max == 0){
			$(self.nextID).css('display', 'none');
			$(self.backID).css('display', 'none');
		}

		if (data['header']['isNext']){
			$(this.bID).css('display', 'block');
		}else{
			$(this.bID).css('display', 'none');
		}

		var html = '';

		for (var key in data['arrayItem']){
			var divID = id + '_' + self.count;
			html = '<div id="' + divID.replace('#', '') + '">' + self.html + '</div>';
			$(this.id).append(html);

			for (var key2 in data['arrayItem'][key]){

				if (key2){
					$(divID).find('.' + key2).html(data['arrayItem'][key][key2]);
				}
			}
			self.count++;
		}

		self.moveSlideHandle();

		complateSlideHandle(data);
	}

	this.moveSlideHandle = function(){
		if (self.isSlide){
			$(self.id).animate({'margin-left': '-' + ((self.page) * self.widthSlide) + 'px'});
		}
	}

	this.onMoreHandle = function(){
		self.load();
	}

	//スライダーとしての設定
	this.setSlide = function(nextID, backID, slide){
		self.nextID = nextID;
		self.backID = backID;

		$(nextID).bind('click', '', self.onNextHandle);
		$(backID).bind('click', '', self.onBackHandle);

		self.widthSlide = $(slide).width();
		self.slideID = slide;
		self.isSlide = true;
	}

	//スライダーの次へを選択
	this.onNextHandle = function(){
		if (self.page  >= self.max){
			self.page = -1;
			//$(self.id).css('margin-left', self.widthSlide + 'px');
		}

		self.load();
	}
	//スライダーの前へを選択
	this.onBackHandle = function(){
		if (self.page -1 < 0){
			self.page = self.max + 1;
		}

		self.load(-1);
	}

	if (this.bID){
		$(this.bID).bind('click', '', this.onMoreHandle);
	}
}