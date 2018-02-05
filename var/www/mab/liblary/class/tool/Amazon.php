<?php

	class ToolAmazon{
	var $access_key_id='AKIAI3K6NCM6ID2IDG3Q';//
	var $secret_access_key='SfOOwy5cyrkYjUwEu50arb6JeuTA8+y1jnRLlP8b';//
	var $AssociateTag='brainofkeios-22';//

		function urlencode_rfc3986($str){
			return str_replace('%7E', '~', rawurlencode($str));
		}
  
		/*
		All  全て
		Apparel  アパレル
		Baby  ベビー＆マタニティ
		Books  本(和書)
		Electronics  エレクトロニクス
		VideoGames  ゲーム
		*/
	  function getSimilarityLookup($itemid){		  
		  //RFC3986形式でURLエンコードする関数
		  
			  $baseurl='http://ecs.amazonaws.jp/onca/xml';
			  $params=array();
			  $params['Service']='AWSECommerceService';
			  $params['AWSAccessKeyId']=$this->access_key_id;
			  $params['Version']='2011-08-01';
			  $params['Operation']='SimilarityLookup';//この商品を買ってます
			  $params['ItemId']=$itemid;;//この商品を買ってます
			  $params['Availability']='Available';
			  $params['AssociateTag']=$this->AssociateTag;
			  $params['ResponseGroup']='Large,OfferFull,ItemAttributes';//'Medium';
			  $params['Condition']='All';//中古品も含める
			  $params['ItemPage']=1;//何ページ目か
			  //Timestamp パラメータを追加します
			  //-時間の表記は ISO8601 形式、タイムゾーンは UTC(GMT)
			  $params['Timestamp']=gmdate('Y-m-d\TH:i:s\Z');
	  
			  //パラメータの順序を昇順に並び替えます
			  ksort($params);
	  
			  //canonical string を作成します
			  $canonical_string='';
			  foreach ($params as $k => $v) {
				  $canonical_string .= '&'.$this->urlencode_rfc3986($k).'='.$this->urlencode_rfc3986($v);
			  }
			  $canonical_string=substr($canonical_string, 1);
	  
			  //署名を作成します
			  //-規定の文字列フォーマットを作成
			  //-HMAC-SHA256を計算
			  //-BASE64エンコード
			  $parsed_url=parse_url($baseurl);
			  $string_to_sign="GET\n{$parsed_url['host']}\n{$parsed_url['path']}\n{$canonical_string}";
			  $signature=base64_encode(hash_hmac('sha256', $string_to_sign, $this->secret_access_key, true));
	  
			  //URLを作成します
			  //-リクエストの末尾に署名を追加
			  $url=$baseurl.'?'.$canonical_string.'&Signature='.$this->urlencode_rfc3986($signature);
	  
			  $amazon_xml=simplexml_load_string(@file_get_contents($url));
	  
			  $data = array();
			  foreach((object) $amazon_xml->Items->Item as $item_a=>$item){

					  $data[] = array(
							  'ASIN' => (string) $item->ASIN,
							  'DetailPageURL' => (string) $item->DetailPageURL,
							  'SalesRank' =>(string)   $item->SalesRank,
							  'Title'=> (string) $item->ItemAttributes->Title,
							  'Artist'=> (string) $item->ItemAttributes->Artist,
							  'SmallImage' => (string)  $item->SmallImage->URL,
							  'MediumImage' =>(string)   $item->MediumImage->URL,
							  'LargeImage' => (string)  $item->LargeImage->URL,
							  'ThumbnailImage' => (string)  $item->ThumbnailImage->URL,
							  'EAN' =>(string)   $item->ItemAttributes->EAN,
							  'LowestNewPrice' =>(string)  $item->OfferSummary->LowestNewPrice->Amount,
							  'LowestUsedPrice' =>(string)  $item->OfferSummary->LowestUsedPrice->Amount
					  );
	  
	  
			  }
			  return $data;
	  }
  
  
  
    function getKeyword($key,$type="All"){	
		  $this->AssociateTag='brainofkeios-22';
		  //RFC3986形式でURLエンコードする関数
			  $baseurl='http://ecs.amazonaws.jp/onca/xml';
			  $params=array();
			  $params['Service']='AWSECommerceService';
			  $params['AWSAccessKeyId']=$this->access_key_id;
			  $params['Version']='2011-08-01';
			  $params['Operation']='ItemSearch';//商品名や著者名でキーワード検索
			  $params['SearchIndex']=trim($type);
			  $params['Availability']='Available';
			  $params['Keywords']=trim($key);//検索ワードを指定
			  $params['AssociateTag']=$this->AssociateTag;
			  $params['ResponseGroup']='Large,OfferFull';//'Medium';
			  $params['Condition']='All';//中古品も含める
			  $params['ItemPage']=1;//何ページ目か
			  //Timestamp パラメータを追加します
			  //-時間の表記は ISO8601 形式、タイムゾーンは UTC(GMT)
			  $params['Timestamp']=gmdate('Y-m-d\TH:i:s\Z');
	  
			  //パラメータの順序を昇順に並び替えます
			  ksort($params);
	  
			  //canonical string を作成します
			  $canonical_string='';
			  foreach ($params as $k => $v) {
				  $canonical_string .= '&'.$this->urlencode_rfc3986($k).'='.$this->urlencode_rfc3986($v);
			  }
			  $canonical_string=substr($canonical_string, 1);
	  
			  //署名を作成します
			  //-規定の文字列フォーマットを作成
			  //-HMAC-SHA256を計算
			  //-BASE64エンコード
			  $parsed_url=parse_url($baseurl);
			  $string_to_sign="GET\n{$parsed_url['host']}\n{$parsed_url['path']}\n{$canonical_string}";
			  $signature=base64_encode(hash_hmac('sha256', $string_to_sign, $this->secret_access_key, true));
	  
			  //URLを作成します
			  //-リクエストの末尾に署名を追加
			  $url=$baseurl.'?'.$canonical_string.'&Signature='.$this->urlencode_rfc3986($signature);
	  
			  $amazon_xml=simplexml_load_string(@file_get_contents($url));

			  $data = array();
			  foreach((object) $amazon_xml->Items->Item as $item_a=>$item){ 
					  $data[] = array(
							  'ASIN' => (string) $item->ASIN,
							  'DetailPageURL' => (string) $item->DetailPageURL,
							  'SalesRank' =>(string)   $item->SalesRank,
							  'Title'=> (string) $item->ItemAttributes->Title,
							  'SmallImage' => (string)  $item->SmallImage->URL,
							  'MediumImage' =>(string)   $item->MediumImage->URL,
							  'LargeImage' => (string)  $item->LargeImage->URL,
							  'ThumbnailImage' => (string)  $item->ThumbnailImage->URL,
							  'Author' => (string)  $item->ItemAttributes->Author,
							  'EAN' =>(string)   $item->ItemAttributes->EAN,
					  );
			  }
	  
	  return $data;
	}

	}
?>