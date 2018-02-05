<?php
	require_once dirname(__FILE__) . '/Model.php';


	/*
	*	DBのモデル
	*/
	class ModelDB extends Model{
	var $conn;									/*データベースクラス*/
	var $tableName;							/*デフォルトテーブル名*/
	var $sql='';								/*実行したＳＱＬの格納*/

	var $tID='id';							/*テーブルのID*/
	var $joinsModel=array();		/*連結させるモデル*/
	var $order='';							/*並び順のキー*/
	var $group='';							/*グループのキー*/
	var $having='';							/*HAVINGの条件*/
	var $limit=0;
	var $target = '*';					/*戻り*/
	var $isDB=true;							/*DBに保存するか*/

	var $isFormat = true;
	var $arrayQuery = array();
	var $arraySQL = array();
	var $flgDel = false;
	var $arraySQLData;

		/*
		*	コンストラクタ
		*/
		function __construct($tableName=''){
			if ($tableName){$this->tableName = $tableName;}

			if (empty($GLOBALS['dbConn'])){
				try {
					$this->conn = new PDO('mysql:host=' . db_host . '; dbname='. db_db,db_user, db_pass);
					$stmt = $this->conn->prepare("SET CHARACTER SET utf8;");
					$stmt->execute();

				}catch(PDOException $e){
				  var_dump($e->getMessage());
				}

				$GLOBALS['dbConn'] = $this->conn;
			}else{
				$this->conn = $GLOBALS['dbConn'];
			}
		}

		/*
		*	SQL発行の際の共通動作
		*/
		function common(){
			if ($this->flgDel){
				$this->addQuery($this->tableName . '.' . $this->flgDel, '0');
			}

			$tableName = $this->tableName . '.';

			if (empty($this->order)){$this->order = $tableName . $this->tID . ' DESC';}
			if (empty($this->group)){$this->group = $tableName . $this->tID;}
			if (empty($this->target)){
				if ($this->tID){
					$this->target .= '*,' . $tableName . $this->tID . ' as id';
				}
			}

		}

		function commonAffter(){
			$this->arrayQuery = array();
			$this->target = '*';
			$this->group = '*';
		}

		/*
		*	キーを指定してデータの取得(uidをキーにする)
		*	@params uid IDを指定
		*	@return 取得データ
		*/
		function getDataUID($uid){
			$this->addQuery($this->tableName . '.' . $this->tID,  $uid);

			$this->getDataSQL();
			
			return $this->getResult();
		}

		/*
		*	データを取得する
		*	@return 取得データ
		*/
		function getData(){

			$this->getDataSQL();

			if (($this->limit) || isset($this->page)){$this->sql.= ' LIMIT ';}
			if (isset($this->page)){
				$this->sql.= (intval($this->page) * $this->limit) . ',';
			}

			if ($this->limit){$this->sql.= $this->limit;}

			return $this->getResult();
		}

		/*
		*	データを取得するSQLの生成
		*/
		function getDataSQL(){
			$this->common();

			$this->sql = $this->getSQLJoins();
			$this->sql.= $this->getSQLSearch();
			$this->sql.= $this->getSQLExt();
		}

		/*
		*	キーを指定してデータの削除
		*	@params uid ID
		*/
		function delDataUID($uid=''){
			$this->common();

			if ($uid){
				$this->arrayQuery[0][$this->tID] = $uid;

				$this->sql = $this->getSQLJoins();
				$this->sql.= $this->getSQLSearch();

				$this->DBBase->delDataSelect($this->sql, $this->arraySQLData);
			}

			$this->commonAffter();
		}

		/*
		*	データの削除
		*/
		function delData(){
			$this->common();

			$this->sql = $this->getSQLJoins();
			$this->sql.= $this->getSQLSearch();

			if ($this->sql){
				$sql = 'DELETE FROM ' . $this->tableName . ' ' . $this->sql;
				$this->query($sql);
			}

			$this->commonAffter();
		}

		/*
		*	テーブルにデータを追加
		*	@paramse $arrayData 関数ごとの指定の場合
		*/
		function addData($arrayData=array()){
			if ($arrayData){$this->arrayData = $arrayData;}

			$this->arrayData['created'] = date('Y-m-d H:i:s');
			$this->arrayData['modified'] = date('Y-m-d H:i:s');

			$sql = '';
			$add = '';

			$this->arraySQLData = array();
			$i = 0;
			foreach ($this->arrayData as $key => $item){
				$sql .= '`' . $key . "`,";
				$add .= '?,';

				$this->arraySQLData[$i] = $item;
				$i++;
			}
			$sql = substr($sql, 0, strlen($sql) - 1);
			$add = substr($add, 0, strlen($add) - 1);

			$sql = 'INSERT INTO ' . $this->tableName . '(' . $sql . ') VALUES(' . $add . ')';

			$this->query($sql);
		}

		/*
		 * 条件によるデータの変更
		 * @paramse $arrayData 関数ごとの指定の場合
		 */
		function setData($arrayData=array()){
			if ($arrayData){$this->arrayData = $arrayData;}

			$sqlWhere = $this->getSQLSearch();

			
			$this->arrayData['modified'] = date('Y-m-d H:i:s');

			$i = 0;
			$set2 = '';
			foreach ($this->arrayData as $key => $item){

					if ($item ===  'key'){
						$set2 .= $key . ",";
					}else{
						$set2 .= "`" . $key . "`=?,";

						if (!strlen($item)){$item = NULL;}

						$arraySetSQLData[$i] = $item;
						$i++;
					}
			}



			$set = substr($set2, 0, strlen($set2) - 1);
			$sql = 'UPDATE ' . $this->tableName . ' SET ' . $set;

			$this->arraySQLData = array_merge($arraySetSQLData, $this->arraySQLData);

			if ($sqlWhere){
				$sql.= $sqlWhere;
			}

			$this->query($sql);
			$this->commonAffter();

			return true;
		}

		/*
		 * IDを元にデータの変更
		 * @param $id 変更する予定のID $arrayData 変更後のデータ
		 * return エラーかどうか
		 */
		function setDataUID($id, $arrayData){
			$this->addQuery($this->tID, $id);

			$this->setData($arrayData);
		}

		/*
		 * データを見て、検索用のSQLの整形
		 */
		function getSQLSearch($arrayQuery=''){
			$this->arraySQLData = array();
			$arrayData = array();
			$sql = '';

			if (!$arrayQuery){$arrayQuery = $this->arrayQuery;}

			if ($arrayQuery){
				foreach ($arrayQuery as $arrayQuery2){
					foreach ($arrayQuery2 as $key => $item){
						$type = ' AND ';
						if (strpos($key, 'AND ') !== FALSE){$key = str_replace('AND ', '', $key);$type = ' AND ';}
						if (strpos($key, 'OR ') !== FALSE){$key = str_replace('OR ', '', $key);$type = ' OR ';}
						if (strpos($key, 'NON ') !== FALSE){$key = str_replace('NON ', '', $key);$type = '';}

						if ($sql){
							$sql.= $type;
						}

						if (!strlen($item) ){
							$sql.=$key;
						}else{
							if ((!strpos($key, '>') ) && (!strpos($key, '<') ) && (!strpos($key, 'LIKE') ) ){$key .= ' = ';}

							$sql .= $key . ' ?';
							array_push($arrayData, $item);
						}
					}
				}

				$sql = ' WHERE ' . $sql;
				$this->arraySQLData = $arrayData;
			}


			return $sql;
		}

		/*
		*	テーブルの連結の処理
		*	@return SQL文
		*/
		function getSQLJoins(){
			$sql = '';
			$target = '';

			if (is_array($this->joinsModel)){
				foreach ($this->joinsModel as $item){
					if (!isset($item['type'])){$item['type'] = 'LEFT';}
					$model = parent::getModel($item['model']);

					if (isset($item['on'])){
						$on = $item['on'];
					}else{
						if (isset($item['id']) ){
							$on = $model->tableName . '.' . $this->tableName . '_' . $model->tID . '=' . $this->tableName . '.' . $this->tID;
						}else{
							$on = $model->tableName . '.' . $model->tID . '=' . $this->tableName . '.' . $model->tableName . '_' . $model->tID;
						}
					}

					$sql.= ' ' . $item['type'] . ' JOIN ' . $model->tableName . ' ON ' . $on;
				}

			}

			$this->joinsModel = array();

			return $sql;
		}

		/*
		* データを見て、それ以外のSQLの整形
		* @return SQLを返す
		*/
		function getSQLExt(){
			$sql = '';

			if ($this->group != '*'){
				$sql.= ' GROUP BY ' . $this->group;
			}

			if (!empty($this->having)){
				$sql.= ' HAVING ' . $this->having;
			}

			$sql.=  ' ORDER BY ' . $this->order;


			return $sql;
		}

		/*
		 * 条件の追加
		 * @params key カラム名などのキー value 値
		 */
		function addQuery($key, $value=''){
			array_push($this->arrayQuery, array($key => $value));
		}

		/*
		 * joinの追加
		 * @params joinsの項目
		 */
		function addJoins($arrayJoins){
			$this->joinsModel[$arrayJoins['model']] =  $arrayJoins;
		}

		/*
		*	直前のSQLの画面出力
		*/
		function log(){
			$log = '';


			//実行したSQLの取得
			$log .= '■SQL<br>' . $this->stmt->queryString . '<br>';
			$log .= '■データ<br>';

			if ($this->arraySQLData){
				foreach ($this->arraySQLData as $key => $item){
					$log .= $key . '/' . $item . '<br>';
				}
			}

			$log .= '<br><br>';
			

			return $log;
		}

		/*
		*	テーブルの情報を取得クラスにて返す
		*	@return 取得クラス
		*/
		function getResult(){
			$sql = 'SELECT '. $this->target . ' FROM ' . $this->tableName . ' ' . $this->sql;
			$this->stmt = $this->query($sql);

			$this->commonAffter();

			if ($this->stmt){
				$this->dbGet = new DBGet($this->stmt, $this);

				return $this->dbGet;
			}else{
				return false;
			}
		}


		/*
		*	実行データを処理
		*/
		function query($sql){
			$stmt = $this->conn->prepare($sql);

			if ($this->arraySQLData){
				$stmt->execute($this->arraySQLData);
			}else{
				$stmt->execute();
			}

			$this->stmt = $stmt;

			$arrayError = $stmt->errorInfo();
			if ($arrayError[0] == '0000'){
				return $stmt;
			}

			if (DEBUG_MODE == 1){
				echo 'error<br />';
				echo $this->log();
				print_r($arrayError);
			}

			return false;
		}

		/*
		*	テーブル情報の消去
		*/
		function clear(){
			$this->query('TRUNCATE TABLE ' . $this->tableName);
		}

		/*
		*	データのコミット
		*/
		function commit($arrayData){
			if (!empty($arrayData[$this->tID])){
				//IDがある場合は修正
				$this->addQuery($this->tID, $arrayData[$this->tID]);
				$flgResult = $this->setData($arrayData);

				return $arrayData[$this->tID];
			}

			//指定したIDがテーブル内に無い場合は追加
			$this->addData($arrayData);
			$uid = $this->conn->lastInsertId();

			return $uid;
		}
	}

	/*
	*	取得したDBの情報を扱うクラス
	*/
	class DBGet{
		var $stmt;

		function __construct($stmt, $modelDB){
			$this->stmt = $stmt;
			$this->modelDB = &$modelDB;
		}

		function getData(){
			$this->arrayData = $this->stmt->fetch(PDO::FETCH_ASSOC);
			return $this->arrayData;
		}
		function getDataAll(){
			$arrayResult = array();
			
			$i = 0;
			while ($item = $this->stmt->fetch(PDO::FETCH_ASSOC) ){
				$arrayResult[$i] = $item;
				$i++;
			}

			return $arrayResult;
		}
		function getCount(){
			return $this->stmt->rowCount();
		}
		function commit(){
			return $this->modelDB->commit($this->arrayData);
		}

	}
?>