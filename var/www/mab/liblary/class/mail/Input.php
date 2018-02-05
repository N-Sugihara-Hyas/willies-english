<?php

require_once dirname(__FILE__) . '/../../PEAR/mimeDecode.php';


/*
*	メールを送信するクラス
*/
class MailInput{

	var $encode 	= 'UTF-8';					/**プログラム内の文字コード**/
	var $mailMime;
	var $mime;

	var $arrayData;

	/*
	 * コンストラクタ
	 * @param arrayData テストデータがある場合は入れることが可能
	 */
	function MailInput($arrayData=array()){
		//DEBUG_MODEで取得方法の区分け
		if (DEBUG_MODE > 0){
			$this->mime->headers['to'] = $arrayData['to'];
			$this->mime->headers['from'] = $arrayData['from'];
			$this->mime->headers['subject'] = $arrayData['subject'];
			$this->mime->ctype_primary = 'text';
			$this->mime->body = $arrayData['body'];
			
			$this->encodeFrom = 'SJIS';
		}else{
			while(!feof(STDIN)) {
				$source .= fread(STDIN, 4096);
			}

			$this->mailMime = new Mail_mimeDecode($source);
			$this->mime = $this->mailMime->decode(array('include_bodies' => true,
			                                      'decode_headers' => true,
			                                      'decode_bodies'  => true,
			                                      'input'          => $source,
			                                      ));

			if ($this->mime->ctype_parameters['charset']){
				$this->encodeFrom = $this->mime->ctype_parameters['charset'];
			}else{
				$this->encodeFrom = 'jis';
			}
		}
	}

	/*
	*	メールのデータの取得
	*	@return メールデータ
	*/
	function getData(){
		$this->arrayData['headers'] = $this->mime->headers;

		$arrayHeader = array('from', 'to');
		
		foreach ($arrayHeader as $item){
			$mail = $this->mime->headers[$item]; 
			$mail = addslashes($mail); 
			$mail = str_replace('"','',$mail); 

			//署名付きの場合の処理を追加 
			preg_match("/<.*>/",$mail,$str); 
			if(isset($str[0]) ){ 
		    	$str=substr($str[0],1,strlen($str[0])-2); 
		    	$mail = $str; 
		  	}

			$this->arrayData['headers'][$item] = $mail;
		}	


		//文字コードの取得
		$this->encodingFrom = $this->mime->ctype_parameters['charset'];

		$this->arrayData['headers']['subject'] = mb_convert_encoding($this->arrayData['headers']['subject'],$this->encode,$this->encodeFrom); 


		$i = 0;
		switch(strtolower($this->mime->ctype_primary)){
    	case "text": // シングルパート(テキストのみ) 
      		$this->arrayData['body'] = mb_convert_encoding($this->mime->body,$this->encode,$this->encodeFrom); 
		break;
    	case "multipart":  // マルチパート(画像付き) 
      		foreach($this->mime->parts as $part){ 
        		switch(strtolower($part->ctype_primary)){ 
          		case "text": // テキスト 
            		$this->arrayData['body'] = mb_convert_encoding($part->body,$this->encode,$this->encodeFrom); 
            	break; 
          		case "image": // 画像
            	//画像の拡張子を取得する(小文字に変換 
            		$type = strtolower($part->ctype_secondary); 
		            $this->arrayData['pic'][$i]['body'] = $part->body;
		            $this->arrayData['pic'][$i]['mime'] = 'image/' . $type; 

								$i++;
           	 	break; 
	        	}
	      	} 

    	break; 
	  	} 

		return $this->arrayData;
	}
}


?>