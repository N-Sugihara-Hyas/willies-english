<?php
	$self->maxOwn = 10; //ナビで表示するカウント数
	
		/*
		*	検索条件をまとめて、リストを取得
		*	@param $dbGet 対象のDB $page 現在のページ数 $limit 1Pあたり
		*	@return 検索結果のデータ
		*/
		$self->parent->pageGetData = function($dbGet, $page, $limit=30) use ($self){
			$arrayResult['page'] = $page;
			$arrayResult['total'] = $dbGet->getCount();	//総合数の取得
			
			$dbGetLimit = new DBGet($dbGet->modelDB->query($dbGet->stmt->queryString . ' LIMIT ' . ($page * $limit) . ',' . $limit), $dbGet->modelDB);	//ページ制限をかけたSQL

			$arrayResult['count'] = $dbGetLimit->getCount();	//現表示数の取得
			

			$arrayResult['dbGet'] = $dbGetLimit;
			
			$arrayResult['naviCountMax'] = $arrayResult['total'] / $limit;


			if ($arrayResult['total']){
				$naviCountEnd = $arrayResult['total'] / $arrayResult['count'];
				
				$min = $page;
				$max = $page+$self->maxOwn;
				
				if ($max > $naviCountEnd){
					$min-=$max-$naviCountEnd;
					if ($min){$min = 0;}

					$max = $naviCountEnd;
				}

				if ($max < 2){
					$arrayResult['arrayCount'] = array();
				}else{
					for ($i = $min; $i < $max; $i++){
						$arrayResult['arrayCount'][$i] = $i + 1;
					}
				}
				
				$arrayResult['min'] = $page * $limit + 1;
				$arrayResult['max'] = $page * $limit + $limit;
				

				if ($page > 0){
					$arrayResult['back'] = $page - 1;
				}
				
				if ($max-1 > $page){
					$arrayResult['next'] = intval($page) + 1;
				}
				
				return $arrayResult;
			}else{
				$arrayResult['naviCountEnd'] = 0;
			}

			return $arrayResult;
		};
?>