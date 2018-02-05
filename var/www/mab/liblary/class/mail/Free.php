<?php

/*
 * フリーメールアドレスの扱いのクラス
 */
class MailFree{
var $arrayFree;		/*フリーメールアドレスのリスト*/

	/*
	 * コンストラクタでフリーアドレスのドメインの設定
	 */
	function MailFree(){
		$this->arrayFree = explode('|', 'yahoo.co.jp|excite.co.jp|lycos.jp|excite.co.jp|lycos.jp|mail.goo.ne.jp|infoseek.jp|
com|itpmail.itp.ne.jp|honey.candy-cafe.com|j-wave.net|m.walkerplus.com|cafesta.com|pt.tokainavi.ne.jp|
inter7.jp|melu.jp|netzone.cc|brassband.jp|hikyaku.com|tok2.com|iiwa.net|mattete.net|honki.net|tamageta
.net|vo-ov.net|mo-om.net|mxxm.net|vxxv.net|v99v.net|to-sen.net|presentget.net|enkaibucho.net|nabebugyo
.net|oto-3.net|oka-3.net|oni-3.net|one-3.net|funifuni.net|bashibashi.net|patipati.net|pop-cute.net|can
dy-pop.net|gogopop.net|mamegohan.net|karaage.net|atarime.net|25cent.net|candypot.net|ganbo.net|do-z.ne
t|saku2.com|comeon.cx|i.117.cx|pc.117.cx|cx.117.cx|pet.117.cx|mail.117.cx|i.707.to|pc.707.to|to.707.to
|pet.707.to|mail.707.to|pets-mail.com|nakayoshi.cc|loveboat.cx|hyper.cx|1dk.jp|infoseek.to|anet.ne.jp|
csc.jp|mcn.ne.jp|kix.ne.jp|kanagawa.to|hotmail');

	}
	
	/*
	 * フリーアドレスでは無いかのチェック
	 */
	function isNotFree($email){
		$isNotFree = true;
		
		foreach ($this->arrayFree as $item){

			if (strpos($email, $item)){
				$isNotFree = false;
			}
		}
		
		return $isNotFree;
	}
}


?>