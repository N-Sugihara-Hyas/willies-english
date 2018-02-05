
function AjaxStation(apiLine, apiStation, areaID, lineID, stationID){
var self = this;
this.apiLine = apiLine;
this.apiStation = apiStation;
this.areaID = areaID;
this.lineID = lineID;
this.stationID = stationID;
this.selectValLine = 0;
this.selectValStation = 0;

	if (this.areaID){
		$(this.areaID).bind('change', '', function(){
			self.loadLine();
		});
	}
	if (this.lineID){
		$(this.lineID).bind('change', '', function(){
			self.loadStation();
		});
	}
	//指定された路線の取得
	this.loadLine = function(aID){
		var ajaxArea = new AjaxServer(self.apiLine);

		ajaxArea.selectFromID = self.areaID;
		ajaxArea.selectToID = self.lineID;

		ajaxArea.selectVal = self.selectValLine;

		ajaxArea.dataType = 'json';
		ajaxArea.access();


		ajaxArea.fnc = function(){

			if ($(self.lineID).val()){
				self.loadStation();
			}
		}

	}

	//指定された路線の取得
	this.loadStation = function(aID){
		var ajaxArea = new AjaxServer(self.apiStation);


		ajaxArea.selectFromID = self.lineID;
		ajaxArea.selectToID = self.stationID;

		ajaxArea.selectVal = self.selectValStation;

		ajaxArea.dataType = 'json';
		ajaxArea.access();
	}

}

