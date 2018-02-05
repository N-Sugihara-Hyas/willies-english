<?php

ini_set('display_errors', '0');

require_once dirname(__FILE__) . '/../../qdmail.php';

/*
 * Qdメールを基板にしたメール送信クラス
 */
class MailQdMail extends Qdmail{

	function MailQdMail( $param = null, $isSmtp = true ){		
		parent::__construct( $param );
		$this->lineFeed("\n");
		
	
		if ($isSmtp){
			$this-> smtp(true);	
		
			$param = array(
			    'host'=>'mypage.willies.jp',
			    'port'=> 587,
			    'from'=>'info@mypage.willies.jp',
			    'protocol'=>'SMTP_AUTH',
			    'user'=>'info',
			    'pass' => 'test5651',
			);
			
			//mypage.willies.jp
			$this-> smtpServer($param);
		}

		//parent::errorDisplay( false );
	}
	
	/*
	 * テンプレートから内容を読み込む
	 * @param tmpName テンプレート名 arrayData パラメータ
	 */
	function setTemplate($tmpName, $arrayData=array()){	
		$body = file_get_contents($tmpName);
		
		$this->setBody($body, $arrayData);
	}
	
	/*
	 * テンプレートから内容を読み込む
	* @param $body 内容データ arrayData パラメータ
	*/
	function setBody($body, $arrayData=array()){
		$body = $this->changeVar($body, $arrayData);

		$this->setBodyHtml(nl2br($body));

		return $body;
	}

	/*
	 * テンプレートから内容を読み込む(HTML)
	* @param $body 内容データ arrayData パラメータ
	*/
	function setBodyHtml($body, $arrayData=array()){
		$body = $this->changeVar($body, $arrayData);

		$this->html( $body );

		return $body;
	}

	/*
	 * テンプレートから変数を置換処理
	* @param $body 内容データ arrayData パラメータ
	*/
	function changeVar($body, $arrayData=array()){	
		foreach ($arrayData as $key => $item){
			$body = str_replace('({$' . $key . '})', $item, $body);
		}

		return $body;
	}



	
	function _send(  ){		
		if (DEBUG_MODE){				
			//非表示にしていたエラーを表示に戻す
			ini_set('display_errors', '1');					
		}else{
			parent::errorDisplay( false );

		}

		
		//ローカルの場合は画面表示にする
		if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false){
			$message = '送り元' . $this->from[0]['mail'] . '<br>';
			$message.= '宛先:' . $this->to[0]['mail'] . '<br>';
			$message.= 'タイトル:' . $this->subject['CONTENT'] . '<br>';
			$message.= '内容:' . $this->content['TEXT']['CONTENT'] . $this->content['HTML']['CONTENT'] . '<br>';
						
			echo $message;
		}else{
			parent::send();
		}		
	}
}


?>