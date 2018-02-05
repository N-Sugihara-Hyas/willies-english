<?php


require_once dirname(__FILE__) . '/../../PEAR/Crypt/Blowfish.php';

/*
*	暗号化クラス
*/
class SecurtyCode{

	/*
	*	コンストラクタ
	*	@params $secretKey シークレットキー
	*/
	function SecurtyCode($secretKey){
		$this->secretKey = $secretKey;

	  /*  $this->td   = mcrypt_module_open('blowfish', '', 'ecb', '');
	    $iv_size   = mcrypt_enc_get_iv_size($this->td);
	    $this->iv   = mcrypt_create_iv($iv_size, MCRYPT_DEV_RANDOM);
	    $this->key  = mcrypt_enc_get_key_size($this->td);
	    mcrypt_generic_init($this->td, $this->key, $this->iv);
	    */
	}

	function common(){
		$this->blowfish = new Crypt_Blowfish($this->secretKey);
	}
	
	/*
	*	暗号化
	*	@params $from 暗号化元
	*/
	function getEncode($from){
		if (!$from){return;}

		
		$this->common();
		
		$code =  base64_encode($this->blowfish->encrypt($from . $this->secretKey));
		
		return $code;
	}

	/*
	*	復号化
	*	@params $from 復号化元
	*/
	function getDecode($from){
		if (!$from){return;}

		$this->common();
		
		$code =  $this->blowfish->decrypt(base64_decode($from));
		
		$num = strpos($code, $this->secretKey);
		$code = substr($code, 0, $num);
		
		return $code;
	}

	/*
	*	暗号化(パスワードも自動発行)
	*	@params $num 文字数
	*/
	function getEncodeRandom($num){
		require_once dirname(__FILE__) . '/../inoutput/String.php';
		
		$from = InoutputString::getRandomString($num);

		$code = $this->getEncode($from);

		return array($from, $code);
	}

}

?>