<?php

/*
*	携帯キャリアの処理
*/
class MobileCarrier{
	var $arrayDomain;
	var $cerrier;
	var $cerrierNo;
	var $arraySmart;

	/*
	*	コンストラクタ
	*/
	function MobileCarrier(){
		$this->arrayDomain = array(
			'docomo.ne.jp',
			'ezweb.ne.jp',
			'softbank.ne.jp',
			'disney.ne.jp',
			't.vodafone.ne.jp',
			'd.vodafone.ne.jp',
			'h.vodafone.ne.jp',
			'c.vodafone.ne.jp',
			'k.vodafone.ne.jp',
			'r.vodafone.ne.jp',
			'n.vodafone.ne.jp',
			's.vodafone.ne.jp',
			'q.vodafone.ne.jp');

		$this->arraySmart = array(
			'iPhone',			// Apple iPhone
			'iPod',				// Apple iPod touch
			'Android',			// 1.5+ Android
			'dream',			// Pre 1.5 Android
			'CUPCAKE',			// 1.5+ Android
			'blackberry9500',	// Storm
			'blackberry9530',	// Storm
			'blackberry9520',	// Storm v2
			'blackberry9550',	// Storm v2
			'blackberry9800',	// Torch
			'webOS',			// Palm Pre Experimental
			'incognito',		// Other iPhone browser
			'webmate'			// Other iPhone browser
		);

	}

	/*
	*	該当ドメインが携帯用か？
	*	@params $domain ドメイン
	*	@return 真か偽か
	*/
	function checkDomain($domain){
		$list = explode('@', $domain);

		if ($list[1]){
			$domain = $list[1];
		}

		foreach ($this->arrayDomain as $item){
			if ($item == $domain){
				return true;
			}
		}

		return false;
	}

	/*
	*	携帯のUIDの取得
	*	@return UID
	*/
	function getUID(){
		if (!isset($_SERVER['HTTP_USER_AGENT'])){
			$this->cerrier = 'pc';
			return '';
		}
        $id = '';
        $ua = $_SERVER['HTTP_USER_AGENT'];

        // DoCoMo
        if (!strncmp($ua, 'DoCoMo', 6)) {
            // mova
            if (substr($ua, 7, 3) === '1.0') {
                $pieces = explode('/', $ua);
                $ser = array_pop($pieces);

                if (!strncmp($ser, 'ser', 3)) {
                    $id = $ser;
                }
            }
            // FOMA
            elseif (substr($ua, 7, 3) === '2.0') {
                $icc = substr($ua, -24, -1);

                if (!strncmp($icc, 'icc', 3)) {
                    $id = $icc;
                }
            }

			if (!empty($_SERVER['HTTP_X_DCMGUID'])){
				$id = $_SERVER['HTTP_X_DCMGUID'];
			}else{
				$id = $icc;
			}

			$this->cerrier = 'docomo';
        }

        // Vodafone(PDC)
        elseif (!strncmp($ua, 'J-PHONE', 7)) {
            $pieces = explode('/', $ua);
            $piece_sn = explode(' ', $pieces[3]);
            $sn = array_shift($piece_sn);

            if (!strncmp($sn, 'SN', 2)) {
                $id = $sn;
            }

			$this->cerrier = 'softbank';
        }


        // Vodafone(3G)
        elseif (!strncmp($ua, 'Vodafone', 8)) {
            $pieces = explode('/', $ua);
            $piece_sn = explode(' ', $pieces[4]);
            $sn = array_shift($piece_sn);

            if (!strncmp($sn, 'SN', 2)) {
                $id = $sn;
            }

			$this->cerrier = 'softbank';
        }
        // SoftBank
        elseif (!strncmp($ua, 'SoftBank', 8)) {
            $pieces = explode('/', $ua);
            $piece_sn = explode(' ', $pieces[4]);
            $sn = array_shift($piece_sn);

            if (!strncmp($sn, 'SN', 2)) {
                $id = $sn;
            }

			$this->cerrier = 'softbank';
        }

        // au
        elseif (!strncmp($ua, 'KDDI', 4)
              || !strncasecmp($ua, 'up.browser', 10)
            ) {
            //(au)
            if ($_SERVER['HTTP_X_UP_SUBNO']) {
                $id = $_SERVER['HTTP_X_UP_SUBNO'];
            }

			$this->cerrier = 'au';
        }else{

			$pattern = '/'. implode('|', $this->arraySmart).'/i';
			if (preg_match($pattern, $_SERVER['HTTP_USER_AGENT']) ){
				$this->cerrier = 'Smart';
			}else{
				$this->cerrier = 'pc';
			}
		}

		$this->uID = $id;

        return $id;
    }

	/*
	*	キャリアとSmartフォンの情報をNoで取得
	*	@return キャリアのナンバー
	*/
	function getCerrierNo(){

		if (!$this->cerrier){$this->getUID();}

		$this->cerrierNo =  5;

		if ($this->cerrier == 'docomo'){
			$this->cerrierNo = 1;
		}
		if ($this->cerrier == 'au'){
			$this->cerrierNo = 2;
		}
		if ($this->cerrier == 'softbank'){
			$this->cerrierNo = 3;
		}

		if ($this->cerrier == 'Smart'){
			$this->cerrierNo = 4;
		}

		if ($this->cerrier == 'pc'){
			$this->cerrierNo = 5;
		}

		return $this->cerrierNo;
	}

	/*
	*	キャリアのドメインを全て取得
	*	@return キャリアのドメインの全て
	*/
	function getDomainAll(){
		return $this->arrayDomain;
	}

	/*
	*	キャリア毎のメールTo
	*	@params $comment メール内容 $code 文字コード
	*	@return 変換したメール情報
	*/
	function changeMailTo($comment, $code='UTF-8'){
		if (!$this->cerrier){$this->getUID();}

		if ($this->cerrier == 'softbank'){
			$result = urlencode($comment);
		}elseif($this->cerrier == 'pc'){
			$result = $comment;
		}else{
			$result = urlencode(mb_convert_encoding($comment, 'SJIS', $code));
		}

		return $result;
	}


}

?>