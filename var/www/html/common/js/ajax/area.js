/*
*	住所関連の処理
*/
function AjaxArea(areaID,cityID,townID){
var self = this;
this.areaID = areaID;
this.cityID = cityID;
this.townID = townID;

this.isCity = false;
this.cID = 0 ;

	//郵便番号を２つに分かれてるのを一つにする
	this.areaZipType1 = function(zipID, zipID2, api){
		var zip1 = $(zipID).val();
		var zip2 = $(zipID2).val();

		self.area(zip1 + zip2, api);
	}

	//郵便番号からデータの検索
	this.area  = function(zip, api){
		if (!zip){
			alert('郵便番号を入力して下さい');
		}else{
			var ajaxArea = new AjaxServer(api + zip);
			ajaxArea.dataType = 'json';
			ajaxArea.fnc = this.ajaxArea;
			ajaxArea.access();

		}
	}

	this.ajaxArea = function(data){
		$(self.areaID).val('');
		$(self.cityID).val('');
		$(self.townID).val('');


		if (data.setting_area2_id){
			$(self.areaID).val(data.setting_area2_id);
		}

		if (data.setting_city_id){
			self.cID = data.setting_city_id;
			$(self.cityID).val(data.setting_city_id);
		}
		if (data.townName){
			$(self.townID).val(data.townName);
		}

		if (self.isCity){
			self.ajaxCity.fnc = self.complateAreaHandle;
			self.ajaxCity.access();
		}
	}

	this.setCity = function(cid){
		this.ajaxCity = new AjaxServer('/api/city/');

		this.ajaxCity.selectFromID = self.areaID;
		this.ajaxCity.selectToID = self.cityID;
		this.ajaxCity.dataType = 'json';

		$(self.areaID).bind('change', '', this.ajaxCity.access);

		self.isCity = true;

		if (cid){
			self.cID = cid;
			self.ajaxCity.fnc = self.complateAreaHandle;
			self.ajaxCity.access();
		}
	}

	this.complateAreaHandle = function(data){
		$(self.cityID).val(self.cID);
	}
}

