<?php

	addModel('ModelDB');

	/*
	*	テストのクラス
	*/
	class TestBase extends ModelDB{
	var $tableName = 'test_base';
	var $order = 'test_base.created DESC';

		function joinTakeBase(){
			$this->addJoins(array('model' => 'take/Base'));
		}
		function joinAdminLogin(){
			$this->addJoins(array('model' => 'admin/User'));
		}
		function joinTestDetails(){
			$this->addJoins(array('model' => 'test/Details', 'on' => 'test_base.id=test_details.test_base_id'));
		}
		function joinTestAnser($mid){
			$this->addJoins(array('model' => 'test/Anser', 'on' => 'test_details.id=test_anser.test_details_id AND test_anser.member_base_id=' . $mid));
		}
		function joinTestHistory(){
			$this->addJoins(array('model' => 'test/History', 'on' => 'test_base.id=test_history.test_base_id'));
		}

		function addTestMember(){
			$this->joinTestHistory();
			$this->target.= ',count(DISTINCT member_base_id) as countMember';
		}

		function getType($tid){
			$this->addQuery('test_type_id', $tid);

			return $this->getData();
		}

		/*
		*	星の判定を入れる
		*/
		function getMyStar($star,$mid, $type=0, $cid=0){
			$this->joinTestDetails();
			$this->joinTestAnser();

			if ($star){
				$this->addQuery('test_anser.isOK', 1);
			}else{
				$this->addQuery('test_anser.isOK', 0);
				$this->addQuery('OR test_anser.isOK IS NULL');
			}


			return $this->getMy($mid, $type, $cid);
		}

		/*
		*	自分が見れるカード
		*/
		function getMy($mid, $type=0, $cid=0){
			if ($type){
				$this->addQuery('test_base.type', $type);
			}
			if ($cid){
				$this->addQuery('test_base.id', $cid);
			}


			$this->addQuery('state', 1);

			$this->target = '*,test_base.*';
			$this->addTestDetails($mid);

			return $this->getData();
		}

		/*
		*	カードの付属数、正解数を取得させる
		*/
		function addTestDetails($mid=0){
			$this->joinTestDetails();

			if ($mid){
				$this->joinTestAnser($mid);
			}

			$this->target.= ',COUNT(DISTINCT test_details.id) as countTest';

			if ($mid){
				$this->target.=',SUM(test_anser.isOK) as countAnser';
			}

		}


		function setPage($page){
			$this->pageTest = $page;
			$this->setSession('TestPage', $this->pageTest);
		}

		function getPage(){
			$this->pageTest = $this->getSession('TestPage');

			return $this->pageTest;
		}

		/*
		*	カードのセッションから取得
		*/
		function getTestAll(){
			if (!isset($this->arrayTestDetails)){
				$this->arrayTestDetails = $this->getSession('arrayTestDetails');
				$this->pageTest = $this->getSession('TestPage');
			}

			if (!$this->pageTest){$this->pageTest = 0;}


			return $this->arrayTestDetails;
		}

		/*
		*	カードのセッションから現ページのデータの取得
		*/
		function getTest(){
			$this->getTestAll();

			if (!isset($this->arrayTestDetails[$this->pageTest])){
				return '';
			}else{
				return $this->arrayTestDetails[$this->pageTest];
			}
		}

		/*
		*	カードのセッションへのロード
		*/
		function loadTest($mid, $bid){
			$this->clearTest();

			$TestDetails = $this->getModel('test/Details');
			$dbGet = $TestDetails->getBase($mid, $bid);

			while ($item = $dbGet->getData()){
				$arrayInput['body1'] = $item['body1'];
				$arrayInput['body2'] = $item['body2'];
				$arrayInput['url'] = $item['url'];
				$arrayInput['img'] = $item['img'];

				for ($i = 1; $i <= 4; $i++){
					$arrayInput['select' . $i] = $item['select' . $i];
				}
				$arrayInput['hit'] = $item['hit'];


				$this->addTest($arrayInput);
			}
		}

		/*
		*	カードのセッションへの追加
		*/
		function addTest($arrayInput){
			$this->getTestAll();


			$this->arrayTestDetails[$this->pageTest] = $arrayInput;

			if (!empty($_FILES['img1'])){
				if ($_FILES['img1']['tmp_name']){
					$this->arrayTestDetails[$this->pageTest]['img1File'] = time();
					$this->arrayTestDetails[$this->pageTest]['img1Body'] = base64_encode(file_get_contents($_FILES['img1']['tmp_name']));
					$this->arrayTestDetails[$this->pageTest]['img1Mime'] = $_FILES['img1']['type'];
				}
			}


			$this->pageTest++;
			$this->setSession('TestPage', $this->pageTest);
			$this->setSession('arrayTestDetails', $this->arrayTestDetails);


		}

		/*
		*	カードのセッションの削除
		*/
		function clearTest(){
			$this->setSession('TestPage', 0);
			$this->setSession('arrayTestDetails', array());
		}


		function createTest($arrayBase){
			$arrayData['state'] = $arrayBase['state'];
			$arrayData['fee'] = $arrayBase['fee'];
			$arrayData['feeType'] = $arrayBase['feeType'];
			$arrayData['cource_base_id'] = $arrayBase['cource_base_id'];
			$arrayData['test_type_id'] = $arrayBase['test_type_id'];

			$this->setDataUID($arrayBase['test_base_id'], $arrayData);
			$cid = $arrayBase['test_base_id'];


			$this->getTestAll();

			$TestDetails = $this->getModel('test/Details');

			$TestDetails->addQuery('test_base_id', $cid);
			$arrayDetails = $TestDetails->getData()->getDataAll();

			$MediaImage = $this->getModel('media/Image');

			$i = 0;
			foreach ($this->arrayTestDetails as $item){
				$arrayDetails[$i]['test_base_id'] = $cid;
				$arrayDetails[$i]['body1'] = $item['body1'];
				$arrayDetails[$i]['body2'] = $item['body2'];
				$arrayDetails[$i]['url'] = $item['url'];
				for ($j = 1; $j <= 4; $j++){
					$arrayDetails[$i]['select' . $j] = $item['select' . $j];
				}
				$arrayDetails[$i]['hit'] = intval($item['hit']);

				if (!empty($item['img1File'])){
					//画像がある場合

					$MediaImage->addQuery('fileName', $item['img1File']);
					$arrayMedia = $MediaImage->getData()->getData();

					$arrayMedia['fileName'] = $item['img1File'];
					$arrayMedia['mime'] = $item['img1Mime'];
					$arrayMedia['body'] = $item['img1Body'];

					$MediaImage->commit($arrayMedia);

					$arrayDetails[$i]['img1'] = $arrayMedia['fileName'];
				}

				$TestDetails->commit($arrayDetails[$i]);
				$i++;
			}

			$this->clearTest();
		}

	}
?>