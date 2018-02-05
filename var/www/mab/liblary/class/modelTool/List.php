<?php
		$self->isSort = true;
		$self->isSearch = true;

		/*
		*	検索条件をまとめて、リストを取得
		*	@param $type 取得タイプ $sort 並び替えの種類 $arraySearch 検索する種類 $searchType　検索タイプ
		*	@return 検索結果のデータ
		*/
		$self->parent->listGetData = function($sort='', $arraySearch=array(), $searchType=0) use ($self){
			if ($self->isSort){$self->listSetSort($sort);}
			if ($self->isSearch){$self->listSetSearch($arraySearch, $searchType);}

			$self->target = 'SQL_CALC_FOUND_ROWS ' . $self->target;
			$dbGet = $self->getData();

			return array($self->listGetDataPage($dbGet), $dbGet);
		};
		
		
		/*
		*	ページナビの取得
		*	@param $dbGet データベースの取得データ
		*	@return ページナビ
		*/
		$self->parent->listGetDataPage = function($dbGet) use ($self){
			//総件数の取得
			$stmt = $self->query('SELECT FOUND_ROWS() as count');

			$arrayTotal = $stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_FIRST);
			$arrayResult['count'] = $dbGet->stmt->rowCount() ;
			
			$arrayResult['total'] = $arrayTotal['count'];
			
			if ($arrayResult['total']){				
				$arrayResult['naviCountEnd'] = $arrayResult['total'] / $self->limit;
				
				$min = $self->page;
				$max = $self->page+10;
				if ($max > $arrayResult['naviCountEnd']){
					$min-=$max-$arrayResult['naviCountEnd'];
					if ($min){$min = 0;}

					$max = $arrayResult['naviCountEnd'];
				}
				
				$arrayResult['naviCountStart'] = $min;
				$arrayResult['naviCountEnd'] = $max;

				$arrayResult['min'] = $self->page * $self->limit + 1;
				$arrayResult['max'] = $self->page * $self->limit + $self->limit;


				return $arrayResult;
			}else{
				$arrayResult['naviCountEnd'] = 0;
			}

			return $arrayResult;
		};

		/*
		 * ソートの処理
		 * @params $arraySearch 検索対象
		 */
		$self->parent->listSetSort = function($sort) use ($self){
			if ($sort){
				$self->setSession('listSort', $sort);
			}else{
				$sort = $self->getSession('listSort');
			}
			
			if ($sort){
				$self->order = $sort;
			}
		};

		/*
		 * 検索の処理
		 * @params $arraySearch 検索対象
		 */
		$self->parent->listSetSearch = function($arraySearch, $searchType) use ($self){
			//タイプが消去の場合
			if ($searchType == 'clear'){
				$arraySearch = array();
				$searchType = 0;

				$self->setSession('arraySearch', $arraySearch);
				$self->setSession('searchType', 1);
			}

			//値の取得
			$arraySession = $self->getSession('arraySearch');
			$sessionSearchType = $self->getSession('searchType');

			foreach ($self->arrayColum as $key => $item){
				if (isset($item['search'])){
					if (isset($arraySearch[$key]) ){
						$self->arrayInput[$key] = $arraySearch[$key];
					}else{
						$self->arrayInput[$key] = getVar($arraySession, $key);
					}
				}
			}

			$type = '';
			if (!$searchType){
				$searchType = $sessionSearchType;
			}


 			if ($searchType == 2){
				$self->searchType = 2;
			}else{
				$type = ' LIKE';
				$self->searchType = 1;
			}

			//値の保存
			if ($arraySearch){
				$self->setSession('arraySearch', $self->arrayInput);
				$self->setSession('searchType', $self->searchType);
			}

			if (isset($self->arrayInput)){
				foreach ($self->arrayInput as $key => $value){
					if ($key == 'keyword'){
						if (strlen($value) ){
							$self->addQuery('(0');

								foreach ($self->arrayKeyword as $item2){
									$self->addQuery('OR ' . $item2 . ' LIKE', '%' . $value . '%');
								}

								$self->addQuery('1)');
							}
						}else{
							if (is_array($value)){
								foreach ($value as $key2 => $value2){
									if (strlen($value2) ){
										if ($key2 == 'LIKES'){
											$self->addQuery($key . ' LIKE',  '%' . $value2 . '%');
										}
										if ($key2 == 'start'){
											$self->addQuery($key .  ' >=', $value2);
										}
										if ($key2 == 'end'){
											$self->addQuery($key .  ' <=', $value2);
										}
										if ($key2 == 'kara'){
											list($start, $end) = explode('-', $value2);
											$self->addQuery($key .  ' >=', $start);
											$self->addQuery($key .  ' <=', $end);
										}
									}
								}
							}else{
								if (strlen($value) ){
									if ($type){
										$self->addQuery($key . ' LIKE', '%' . $value . '%');
									}else{
										$self->addQuery($key . $type, $value);
									}
								}
							}
						}
					}
				}
		};

		/*
		 * IDを選択して削除の処理
		 * @params $arrayDel 削除対象
		 */
		$self->parent->listDelData = function($arrayDel) use ($self){
			if (!$arrayDel){
				return false;
			}

			foreach ($arrayDel as $item){
				$self->addQuery('OR ' . $self->tID, $item);
			}
	
			$self->delData();

			return true;
		};
?>