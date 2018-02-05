/*
*	Ajaxの処理
*/
function AjaxServer(url){
	var self = this;
	this.url = url;
	this.selectToID = '';
	this.selectFromID = '';
	this.selectVal = '';
	this.fnc = '';

	this.access = function(){
		var url = self.url;


		if (self.selectFromID){url += $(self.selectFromID).val() + '/';}

		$.ajax({
			url : url,
			cache: false,
			type : "post",
			data : self.data,
			success: self.complateEndHandle
		});


	}

	this.complateEndHandle = function(data){
		if (self.dataType == 'json'){
			data = $.parseJSON(data);
		}

		if (self.selectToID){
			$(self.selectToID).children().remove();
			$(self.selectToID).append($('<option>').attr({ value: ''}).text('選択してください'));

			for (key in data){
				var arrayResult = data[key];

				if (arrayResult.id){
					$(self.selectToID).append($('<option>').attr({ value: arrayResult.id }).text(arrayResult.value));
				}
			}

			$(self.selectToID).val(self.selectVal);
		}

		if (self.fnc){
			self.fnc(data);
		}
	}
}