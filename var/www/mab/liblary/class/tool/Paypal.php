<?php

class Paypal{
var $debug = true;

	function Paypal($uid, $pass, $signature, $sandbox=false){
		$this->SandboxFlag = $sandbox;


		if ($this->SandboxFlag){
			$this->API_UserName = "contact-facilitator_api1.tejima.jp";
			$this->API_Password = "N88GM3HEK64YTQPC";
			$this->API_Signature = "AUzdz8x4zZpUy9PIo7kPa2fg4fv9AVfmN2ziRFZjsl9d3NZ0e-fFwHhX";
		}else{
			$this->API_UserName = $uid;
			$this->API_Password = $pass;
			$this->API_Signature = $signature;
		}
		
		

		$this->currencyCodeType = "JPY";
		$this->paymentType = "Sale";

		if ($this->SandboxFlag == true) {
			$this->API_Endpoint = "https://api-3t.sandbox.paypal.com/nvp";
			$this->PAYPAL_URL = "https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=";
		} else {
			$this->API_Endpoint = "https://api-3t.paypal.com/nvp";
			$this->PAYPAL_URL = "https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=";
		}
		$this->version = "64";
		if (session_id () == "") {
			session_start ();
		}
	}

	function CallRecurringPayments($paymentAmount, $description, $returnURL, $cancelURL,$INITAMT = 0) {
		$nvpstr = "&AMT=" . $paymentAmount;
		$nvpstr = $nvpstr . "&PAYMENTACTION=" . $this->paymentType;
		$nvpstr = $nvpstr . "&BILLINGAGREEMENTDESCRIPTION=" . urlencode ( $description );
		$nvpstr = $nvpstr . "&BILLINGTYPE=RecurringPayments";
		$nvpstr = $nvpstr . "&RETURNURL=" . $returnURL;
		$nvpstr = $nvpstr . "&CANCELURL=" . $cancelURL;
		$nvpstr = $nvpstr . "&CURRENCYCODE=" . $this->currencyCodeType;

		if($INITAMT != 0){
			$nvpstr = $nvpstr ."&INITAMT=".$INITAMT;
		}
		$resArray = $this->hash_call ( "SetExpressCheckout", $nvpstr );
		$ack = strtoupper ( $resArray ["ACK"] );
		if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
			$token = urldecode ( $resArray ["TOKEN"] );
			$_SESSION ['TOKEN'] = $token;
			return $token;
		} else {
			DebugPrint ( " SetExpressCheckout API call failed.", $resArray );
			return false;
		}
	}
	function GetShippingDetails($token) {
		global $debug;
		$nvpstr = "&TOKEN=" . $token;
		$resArray = $this->hash_call ( "GetExpressCheckoutDetails", $nvpstr );

		$ack = strtoupper ( $resArray ["ACK"] );
		if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
		} else {
			$this->DebugPrint ( " GetExpressCheckoutDetails API call failed.", $resArray );
			return false;
		}
		return $resArray;
	}


	function ConfirmPayment( $AMT,$detail,$description='' )
	    {
	        $token                 = urlencode($detail['TOKEN']);

	        $payerID             = urlencode($detail['PAYERID']);

	        $nvpstr  = '&TOKEN=' . $token . '&PAYERID=' . $payerID
			. '&PAYMENTREQUEST_0_PAYMENTACTION=' . $this->paymentType . '&PAYMENTREQUEST_0_AMT=' . $AMT;
					$nvpstr .= "&DESC=" . urlencode ( $description );
	        $nvpstr .= '&PAYMENTREQUEST_0_CURRENCYCODE=' . $this->currencyCodeType . '&IPADDRESS=' . $_SERVER ['REMOTE_ADDR'];

	        $resArray=$this->hash_call("DoExpressCheckoutPayment",$nvpstr);

	        $ack = strtoupper($resArray["ACK"]);

	        return $resArray;
	    }

	function CreateRecurringPaymentsProfile($paymentAmount, $description,$start,$detail) {
		$nvpstr = "&TOKEN=" .  $detail ['TOKEN'] ;
		$nvpstr .= "&SHIPTONAME=" . $detail ["SHIPTONAME"];
		$nvpstr .= "&SHIPTOSTREET=" .  $detail ["SHIPTOSTREET"];
		$nvpstr .= "&SHIPTOCITY=" . $detail ["SHIPTOCITY"];
		$nvpstr .= "&SHIPTOSTATE=" .$detail ["SHIPTOSTATE"];
		$nvpstr .= "&SHIPTOZIP=" .$detail ["SHIPTOZIP"];
		$nvpstr .= "&SHIPTOCOUNTRY=" . $detail ["SHIPTOCOUNTRYCODE"];
		$nvpstr .= "&PROFILESTARTDATE=" . urlencode ( $start );
		$nvpstr .= "&DESC=" . urlencode ( $description );
		$nvpstr .= "&BILLINGPERIOD=Month";
		$nvpstr .= "&BILLINGFREQUENCY=1";
		$nvpstr .= "&AMT=".$paymentAmount;
		$nvpstr .= "&CURRENCYCODE=".$this->currencyCodeType;
		$nvpstr .= "&IPADDRESS=" . $_SERVER ['REMOTE_ADDR'];
		$resArray = $this->hash_call ( "CreateRecurringPaymentsProfile", $nvpstr );
		$ack = strtoupper ( $resArray ["ACK"] );
		if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
			return $resArray;
		} else {
			DebugPrint ( " GetExpressCheckoutDetails API call failed.", $resArray );
			return false;
		}
	}

	/**
	 *
	 * @param unknown $profile_id
	 * @param unknown $action
	 *        	’Cancel’,'Suspend’,'Reactivate’
	 * @return multitype:string |boolean
	 */
	function change_subscription_status($profile_id, $action) {
		$resArray = hash_call ( "ManageRecurringPaymentsProfileStatus", "&PROFILEID=" . $profile_id . "&ACTION=" . $action );
		$ack = strtoupper ( $resArray ["ACK"] );
		if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
			return $resArray;
		} else {
			DebugPrint ( " ManageRecurringPaymentsProfileStatus API call failed.", $resArray );
			return false;
		}
	}

	/**
	 *
	 * @param unknown $profile_id
	 * @return multitype:string |boolean
	 */
	function check_status($profile_id) {
		$resArray = $this->hash_call ( "GetRecurringPaymentsProfileDetails", "&PROFILEID=" . $profile_id );
		$ack = strtoupper ( $resArray ["ACK"] );
		if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
			return $resArray;
		} else {
			$this->DebugPrint ( " GetRecurringPaymentsProfileDetails API call failed.", $resArray );
			return false;
		}
	}

	function hash_call($methodName, $nvpStr) {
		if($this->SandboxFlag){
		    $POST_DATA = array(
		        "mn"=>$methodName,
		    'data' => ( $nvpStr)
		    );

		    $curl=curl_init("http://stest.package-test.info/paypal/con2.php");
		    curl_setopt($curl,CURLOPT_POST, TRUE);
		    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($POST_DATA));
		    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, FALSE);  // オレオレ証明書対策
		    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, FALSE);  //
		    curl_setopt($curl,CURLOPT_RETURNTRANSFER, TRUE);
		    curl_setopt($curl,CURLOPT_COOKIEJAR,      'cookie');
		    curl_setopt($curl,CURLOPT_COOKIEFILE,     'tmp');
		    curl_setopt($curl,CURLOPT_FOLLOWLOCATION, TRUE); // Locationヘッダを追跡
		    $output= curl_exec($curl);
		    $nvpResArray = unserialize($output);
			return $nvpResArray;}
		else{
			return $this->hash_call2($methodName, $nvpStr);
		}
	}

	function hash_calls() {    
	    $ret = hash_call2($_REQUEST["mn"],$_REQUEST["data"]);
	    echo serialize( $ret);
	    exit();
	}

	function hash_call2($methodName, $nvpStr) {

		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $this->API_Endpoint );
		curl_setopt ( $ch, CURLOPT_VERBOSE, 1 );
		/*curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );*/
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_SSLVERSION, 6); // CURL_SSLVERSION_TLSv1_2

		curl_setopt ( $ch, CURLOPT_POST, 1 );
		
		$nvpreq = "METHOD=" . urlencode ( $methodName ) . "&VERSION=" . urlencode ( $this->version ) . "&PWD=" . urlencode ( $this->API_Password ) . "&USER=" . urlencode ( $this->API_UserName ) . "&SIGNATURE=" . urlencode ( $this->API_Signature ) . $nvpStr ;
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $nvpreq );
		$response = curl_exec ( $ch );
		$nvpResArray = $this->deformatNVP ( $response );
		$nvpReqArray = $this->deformatNVP ( $nvpreq );
		$_SESSION ['nvpReqArray'] = $nvpReqArray;
		if (curl_errno ( $ch )) {
			$_SESSION ['curl_error_no'] = curl_errno ( $ch );
			$_SESSION ['curl_error_msg'] = curl_error ( $ch );
		} else {
			curl_close ( $ch );
		}
		return $nvpResArray;
	}

	function RedirectToPayPal($token) {
		$payPalURL = $this->PAYPAL_URL . $token;
		header ( "Location: " . $payPalURL );
	}

	function deformatNVP($nvpstr) {
		$intial = 0;
		$nvpArray = array ();
		while ( strlen ( $nvpstr ) ) {
			$keypos = strpos ( $nvpstr, '=' );
			$valuepos = strpos ( $nvpstr, '&' ) ? strpos ( $nvpstr, '&' ) : strlen ( $nvpstr );
			$keyval = substr ( $nvpstr, $intial, $keypos );
			$valval = substr ( $nvpstr, $keypos + 1, $valuepos - $keypos - 1 );
			$nvpArray [urldecode ( $keyval )] = urldecode ( $valval );
			$nvpstr = substr ( $nvpstr, $valuepos + 1, strlen ( $nvpstr ) );
		}
		return $nvpArray;
	}
	function DebugPrint($str, $res) {
		global $debug;
		if ($debug) {
			$ErrorCode = urldecode ( $res ["L_ERRORCODE0"] );
			$ErrorShortMsg = urldecode ( $res ["L_SHORTMESSAGE0"] );
			$ErrorLongMsg = urldecode ( $res ["L_LONGMESSAGE0"] );
			$ErrorSeverityCode = urldecode ( $res ["L_SEVERITYCODE0"] );
			echo $str . " <br>";
			echo "Detailed Error Message: " . $ErrorLongMsg . "<br>";
			echo "Short Error Message: " . $ErrorShortMsg . "<br>";
			echo "Error Code: " . $ErrorCode . "<br>";
			echo "Error Severity Code: " . $ErrorSeverityCode . "<br>";
		}
	}

function CallShortcutExpressCheckout( $paymentAmount, $returnURL, $cancelURL,$DESC=""){

	$nvpstr="&PAYMENTREQUEST_0_AMT=". $paymentAmount;
	$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_PAYMENTACTION=" . $this->paymentType;
	$nvpstr = $nvpstr . "&RETURNURL=" . $returnURL;
	$nvpstr = $nvpstr . "&CANCELURL=" . $cancelURL;
	$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_CURRENCYCODE=" . $this->currencyCodeType;
    if($DESC != ""){
	$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_DESC=" . urlencode($DESC);
    }
    
    
	$_SESSION["currencyCodeType"] = $this->currencyCodeType;
	$_SESSION["PaymentType"] = $this->paymentType;
	$resArray=$this->hash_call("SetExpressCheckout", $nvpstr);
	$ack = strtoupper($resArray["ACK"]);
	if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING")
	{
		$token = urldecode($resArray["TOKEN"]);
		$_SESSION['TOKEN']=$token;
		return $token;
	}
	return $resArray;





	}
}