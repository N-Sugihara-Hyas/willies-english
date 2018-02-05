<?php
	require_once dirname(__FILE__) . '/../../opensorce/twitteroauth-master/twitteroauth/twitteroauth.php';

	class ToolTwitter extends TwitterOAuth{
		var $oToken;
		var $oTokenSecret;
		var $oauthVerifier;
		var $accessToken;

		function ToolTwitter($consumerKey, $consumerSecret, $oCallBack, $oauthVerifier='', $oToken='', $oTokenSecret=''){
			$this->oauthVerifier = $oauthVerifier;

			if ($oToken){
					$this->oToken = $oToken;
					$this->oTokenSecret = $oTokenSecret;
			}else{
				if (isset($_SESSION['access_token']) ){
					$this->oToken = $_SESSION['access_token']['oauth_token'];
					$this->oTokenSecret = $_SESSION['access_token']['oauth_token_secret'];
				}
			}


			$this->consumerKey = $consumerKey;
			$this->consumerSecret = $consumerSecret;
			$this->oCallBack = $oCallBack;

			parent::__construct($consumerKey, $consumerSecret, $this->oToken, $this->oTokenSecret);
		}

		function checkAuth(){
			$request_token = $this->getRequestToken($this->oCallBack);
			$_SESSION['access_token']['oauth_token'] = $token = $request_token['oauth_token'];
			$_SESSION['access_token']['oauth_token_secret'] = $request_token['oauth_token_secret'];

			$http_code = $this->http_code;
			switch ($http_code) {
    	case 200:
        /* エラーが無かった場合はツイッターの認証画面へリダイレクト. */
        $url = $this->getAuthorizeURL($token);

				header('Location: '.$url);
				exit;
			default:
				echo 'エラー：もう一度やり直してください。';
				exit;
			} 

		}


		function getTwitter(){
			$result = $this->getAccessToken($this->oauthVerifier);

			return $result;
		}

		function postTwitter($comment){
			$this->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$comment));
		}

	}
?>