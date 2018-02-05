<?php

	class ToolAmazon{
	var $access_key_id='AKIAI3K6NCM6ID2IDG3Q';//
	var $secret_access_key='SfOOwy5cyrkYjUwEu50arb6JeuTA8+y1jnRLlP8b';//
	var $AssociateTag='brainofkeios-22';//

		function urlencode_rfc3986($str){
			return str_replace('%7E', '~', rawurlencode($str));
		}
  
		/*
		All  �S��
		Apparel  �A�p����
		Baby  �x�r�[���}�^�j�e�B
		Books  �{(�a��)
		Electronics  �G���N�g���j�N�X
		VideoGames  �Q�[��
		*/
	  function getSimilarityLookup($itemid){		  
		  //RFC3986�`����URL�G���R�[�h����֐�
		  
			  $baseurl='http://ecs.amazonaws.jp/onca/xml';
			  $params=array();
			  $params['Service']='AWSECommerceService';
			  $params['AWSAccessKeyId']=$this->access_key_id;
			  $params['Version']='2011-08-01';
			  $params['Operation']='SimilarityLookup';//���̏��i�𔃂��Ă܂�
			  $params['ItemId']=$itemid;;//���̏��i�𔃂��Ă܂�
			  $params['Availability']='Available';
			  $params['AssociateTag']=$this->AssociateTag;
			  $params['ResponseGroup']='Large,OfferFull,ItemAttributes';//'Medium';
			  $params['Condition']='All';//���Õi���܂߂�
			  $params['ItemPage']=1;//���y�[�W�ڂ�
			  //Timestamp �p�����[�^��ǉ����܂�
			  //-���Ԃ̕\�L�� ISO8601 �`���A�^�C���]�[���� UTC(GMT)
			  $params['Timestamp']=gmdate('Y-m-d\TH:i:s\Z');
	  
			  //�p�����[�^�̏����������ɕ��ёւ��܂�
			  ksort($params);
	  
			  //canonical string ���쐬���܂�
			  $canonical_string='';
			  foreach ($params as $k => $v) {
				  $canonical_string .= '&'.$this->urlencode_rfc3986($k).'='.$this->urlencode_rfc3986($v);
			  }
			  $canonical_string=substr($canonical_string, 1);
	  
			  //�������쐬���܂�
			  //-�K��̕�����t�H�[�}�b�g���쐬
			  //-HMAC-SHA256���v�Z
			  //-BASE64�G���R�[�h
			  $parsed_url=parse_url($baseurl);
			  $string_to_sign="GET\n{$parsed_url['host']}\n{$parsed_url['path']}\n{$canonical_string}";
			  $signature=base64_encode(hash_hmac('sha256', $string_to_sign, $this->secret_access_key, true));
	  
			  //URL���쐬���܂�
			  //-���N�G�X�g�̖����ɏ�����ǉ�
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
		  //RFC3986�`����URL�G���R�[�h����֐�
			  $baseurl='http://ecs.amazonaws.jp/onca/xml';
			  $params=array();
			  $params['Service']='AWSECommerceService';
			  $params['AWSAccessKeyId']=$this->access_key_id;
			  $params['Version']='2011-08-01';
			  $params['Operation']='ItemSearch';//���i���⒘�Җ��ŃL�[���[�h����
			  $params['SearchIndex']=trim($type);
			  $params['Availability']='Available';
			  $params['Keywords']=trim($key);//�������[�h���w��
			  $params['AssociateTag']=$this->AssociateTag;
			  $params['ResponseGroup']='Large,OfferFull';//'Medium';
			  $params['Condition']='All';//���Õi���܂߂�
			  $params['ItemPage']=1;//���y�[�W�ڂ�
			  //Timestamp �p�����[�^��ǉ����܂�
			  //-���Ԃ̕\�L�� ISO8601 �`���A�^�C���]�[���� UTC(GMT)
			  $params['Timestamp']=gmdate('Y-m-d\TH:i:s\Z');
	  
			  //�p�����[�^�̏����������ɕ��ёւ��܂�
			  ksort($params);
	  
			  //canonical string ���쐬���܂�
			  $canonical_string='';
			  foreach ($params as $k => $v) {
				  $canonical_string .= '&'.$this->urlencode_rfc3986($k).'='.$this->urlencode_rfc3986($v);
			  }
			  $canonical_string=substr($canonical_string, 1);
	  
			  //�������쐬���܂�
			  //-�K��̕�����t�H�[�}�b�g���쐬
			  //-HMAC-SHA256���v�Z
			  //-BASE64�G���R�[�h
			  $parsed_url=parse_url($baseurl);
			  $string_to_sign="GET\n{$parsed_url['host']}\n{$parsed_url['path']}\n{$canonical_string}";
			  $signature=base64_encode(hash_hmac('sha256', $string_to_sign, $this->secret_access_key, true));
	  
			  //URL���쐬���܂�
			  //-���N�G�X�g�̖����ɏ�����ǉ�
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