<?php

	addModel('ModelDB');

	/*
	*	Communicationのクラス
	*/
	class MasterCommunication extends ModelDB{
	var $tableName = 'master_communication';
	var $order = 'dateDay DESC,master_communication.id DESC';

		function joinMemberBase(){
			$this->addJoins(
				array('model' => 'member/Base')
			);
		}

		function addDataType($mID, $targetID, $type){
			$arrayData['member_base_id'] = $mID;
			$arrayData['targetID'] = $targetID;
			$arrayData['dateDay'] = date('Y-m-d');

			/*foreach ($arrayData as $key => $item){
				$this->addQuery($key, $item);
			}*/

			//if (!$this->getData()->getData()){
				if ($type == 'comm'){
					$arrayData['type'] = $type;
					$arrayData['body'] = 'Available new comments on <a href="/mypage/exercise/details/' . $targetID . '/">&lt;Weekly Feedback&gt;</a>';
				}else{
					$arrayData['body'] = $type;
				}
				$this->commit($arrayData);
			//}
		}

		function getDataMixMy($mid){
			$sql = " SELECT master_communication.created,'master_communication' as type,master_communication.isView, dateDay,'0' as gcc,'0' as rlc,'0' as followup,'0' as free,body FROM master_communication";
			$sql.= ' WHERE member_base_id=' . $mid;
			$sql.= ' UNION ALL';


			$str = "'Homework for the next lesson:<br />',";
			$str.= "'- GCC: ', gcc, '<br />',";
			$str.= "'- RLC: ', rlc, '<br />',";
			$str.= "'<br />Follow-up questions:<br />',";
			$str.= "followup, '<br /><br/ >',";
			$str.= "free, '<br /><br/ >'";

			$sql.= " SELECT ext_homework.created,'ext_homework' as type,ext_homework.isView,created as dateDay,gcc,rlc,followup,free,concat(" . $str . ") as body FROM ext_homework";
			$sql.= ' WHERE member_base_id=' . $mid;
			$sql.= ' UNION ALL';


			$str = "'Available new comments on ',";
			$str.= "'<a href=\"/mypage/monthly/details/', ext_monthly.id, '\">',";
			$str.= "'&lt;Review Feedback&gt;</a>'";


			$sql.= " SELECT ext_monthly.created,'ext_monthly' as type,ext_monthly.isView,ext_monthly.created as dateDay,gcc,rlc,'0' as followup,'0' as free,concat(" . $str . ") as body FROM ext_monthly";
			$sql.= " LEFT JOIN take_base ON take_base_id=take_base.id";
			$sql.= ' WHERE ext_monthly.isView = 1 AND member_base_id=' . $mid;
			$sql.= ' UNION ALL';


			$sql.= " SELECT master_news_card.created,'master_news_card' as type,'0' as isView,master_news_card.created as dateDay,master_news_card.card_base_id as gcc,master_news_card.type as rlc,'0' as followup,'0' as free,body FROM master_news_card";
			$sql.= ' WHERE member_base_id=' . $mid;
			$sql.= ' UNION ALL';

			$sql.= " SELECT member_point.created,'member_point' as type,'0' as isView,member_point.created as dateDay,'0' as gcc,'0' as rlc,'0' as followup,'0' as free,action as body FROM member_point";
			$sql.= ' WHERE member_base_id=' . $mid;
			$sql.= ' UNION ALL';

			$sql.= " SELECT member_point_lesson.created,'member_point' as type,'0' as isView,member_point_lesson.created as dateDay,'0' as gcc,'0' as rlc,'0' as followup,'0' as free,action as body FROM member_point_lesson";
			$sql.= ' WHERE member_base_id=' . $mid;

			$sql.= ' ORDER BY created DESC, type DESC';


			return new DBGet($this->query($sql), $this);

		}

		function getDataRecord($mid){
			$str = "'Homework for the next lesson:<br />',";
			$str.= "'- GCC: ', gcc, '<br />',";
			$str.= "'- RLC: ', rlc, '<br />',";
			$str.= "'<br />Follow-up questions:<br />',";
			$str.= "followup, '<br /><br/ >',";
			$str.= "free, '<br /><br/ >'";
			
			$sql.= " SELECT ext_homework.created,'ext_homework' as type,ext_homework.isView,created as dateDay,gcc,rlc,followup,free,concat(" . $str . ") as body FROM ext_homework";
			$sql.= ' WHERE member_base_id=' . $mid;
			$sql.= ' UNION ALL';


			$sql.= " SELECT master_news_card.created,'master_news_card' as type,'0' as isView,master_news_card.created as dateDay,master_news_card.card_base_id as gcc,master_news_card.type as rlc,'0' as followup,'0' as free,body FROM master_news_card";
			$sql.= ' WHERE member_base_id=' . $mid;
			$sql.= ' UNION ALL';


			$str = "'Available new comments on ',";
			$str.= "'<a href=\"/mypage/monthly/details/', ext_monthly.id, '\">',";
			$str.= "'&lt;Review Feedback&gt;</a>'";


			$sql.= " SELECT ext_monthly.created,'ext_monthly' as type,ext_monthly.isView,ext_monthly.created as dateDay,gcc,rlc,'0' as followup,'0' as free,concat(" . $str . ") as body FROM ext_monthly";
			$sql.= " LEFT JOIN take_base ON take_base_id=take_base.id";
			$sql.= ' WHERE ext_monthly.isView = 1 AND member_base_id=' . $mid;
			//$sql.= ' UNION ALL';


			$sql.= ' ORDER BY created DESC, type DESC';

			$dbGet = new DBGet($this->query($sql), $this);
			$arrayRecourd['arrayList'] = $dbGet->getDataAll();

			return $arrayRecourd;

		}
	}
?>