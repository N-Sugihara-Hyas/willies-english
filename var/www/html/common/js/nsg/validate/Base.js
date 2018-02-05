/*
*	フォームのバリデートチェック
*/
function ValidateBase(){
	this.objValidate = new Object();

	/*
	* バリデートの設定
	* @params id バリデータ対象のID type バリデートのタイプ message エラーメッセージ
	*/
	this.addValidate = function (id, type, message, isView){
		if (!this.objValidate[id]){
			this.objValidate[id] = new Object();
			this.objValidate[id]['list'] = new Array();
			this.objValidate[id]['count'] = 0;
		}

		var count = this.objValidate[id]['count'];
		this.objValidate[id]['list'][count] = new Object();
		this.objValidate[id]['list'][count]['type'] = type;
		this.objValidate[id]['list'][count]['message'] = message;
		this.objValidate[id]['list'][count]['isView'] = isView;
		this.objValidate[id]['count']++;

	}

	this.removeValidate = function (id){
		delete this.objValidate[id];
	}

	/*
	* バリデートの実行(配列で実行)
	* @params fID フォームのID isAutoRedirect 自動で画面を飛ばさない
	*/
	this.getValidateArray = function (fID, isNonAutoRedirect){
	var error='';

		for (var key in this.objValidate){
			var errorMessage = '';
			objValidate = this.objValidate[key]['list'];

			for (var key2 in objValidate){
				isErrorView = true;

				//そのエラーは実行条件に入っているか？
				if (objValidate[key2]['isView']){
					isView = objValidate[key2]['isView']


					arrayView = isView.split('=');
					if ($('#' + fID + ' #' + arrayView[0]).val() != arrayView[1]){
						isErrorView = false;
					}
				}

				if (isErrorView){
					errorMessage = this.getValidate(fID, key, objValidate[key2]['type'], objValidate[key2]['message']);
				}


				if (errorMessage){
					$('#' + fID + ' #e_' + key).html(errorMessage);
					error+= errorMessage + "\n";
					break;
				}else{
					$('#' + fID + ' #e_' + key).html('');
				}
			}
		}

		if (!isNonAutoRedirect){
			if (!error){
				$('#' + fID).submit();
			}else{
				alert("■下記のエラーがありました。\n" + error);
			}
		}else{
			return error;
		}
	}

	/*
	*	バリデートのチェック
	* @params fID フォームのID id 項目のID type エラータイプ message　エラーメッセージ
	*/
	this.getValidate = function(fID, id, type, message){
		var value = $('#' + fID + ' #' + id).val();

		switch (type){
		case 'NonSpace':
			return this.NonSpace(value, message);
		break;
		case 'English':
			return this.English(value, message);
		break;
		case 'Number':
			return this.Number(value, message);
		break;
		}
	}

	/*
	*	入力済みかのチェック
	* @params value コントロールの入力値 messageエラーメッセージ
	*	@return エラーの場合、エラーメッセージを返す
	*/
	this.NonSpace = function(value, message){
		if (!value){
			return message;
		}

		return false;
	}

	/*
	*	英数字のチェック
	* @params value コントロールの入力値 messageエラーメッセージ
	*	@return エラーの場合、エラーメッセージを返す
	*/
	this.English = function(value, message){
		var str = value;
		if(str.match( /[^0-9A-Za-z\s.-]+/ ) ){
			return message;
		}
		return false;
	}

	/*
	*	数字かのチェック
	* @params value コントロールの入力値 messageエラーメッセージ
	*	@return エラーの場合、エラーメッセージを返す
	*/
	this.Number = function(value, message){
		var str = value;
		if(str.match( /[^0-9]+/ ) ){
			return message;
		}
		return false;
	}

}
