<?php

require_once dirname(__FILE__) . '/../db/Db.php';

/***********************************************************
*	���O�C��(�[��ID�ł̎������O�C������)
***********************************************************/
class classLoginID extends classDB{
	var $arrayData;
	var $sql;
	var $flgDebug;

	/***********************************************************
	*	�R���X�g���N�^
	*	�f�o�b�N���[�h,�e�[�u����,�Z�b�V�����̖���
	***********************************************************/
	function classLoginID($flgDebug, $tableName, $arrayKou, $arrayData){
		$this->classDB();

		$this->flgDebug = $flgDebug;

		foreach ($arrayKou as $item){
			$this->sql.=' AND ' . $item . '=?';
		}


		$this->arrayData = $arrayData;
		$this->strTableName = $tableName;
	}

	/***********************************************************
	*	���O�C���Ώۂ̍X�V�ӏ��̐ݒ�
	*	����:DB�̌����Ώ�,DB�ւ̌����f�[�^
	***********************************************************/
	function setLoginReflesh($strTime, $ip){
		$this->arrayReflasehData['strTime'] = $strTime;
		$this->arrayReflasehData['ip'] = $ip;
	}

	/***********************************************************
	*	���O�C���Ώۂ̏������āA���O�C��
	*	�Ԃ�l�Ftrue,false
	***********************************************************/
	function checkLogin(){
		if ($this->checkLoginNow()){
			return true;
		}else{
			return false;
		}
	}

	/***********************************************************
	*	���O�C�����������擾
	*	�Ԃ�l�F���O�C���������
	***********************************************************/
	function getData(){
		return $this->arrayInfo;
	}

	/***********************************************************
	*	SID�����āA���O�C�����p������Ă��邩�̊m�F
	*	�Ԃ�l�Ftrue,false
	***********************************************************/
	function checkLoginNow(){
		$this->arrayInfo = $this->getDataSingle('WHERE 1' . $this->sql, $this->arrayData);
		if ($this->arrayInfo){
			$this->setLoginInfo('1' . $this->sql, $this->arrayData);
			return true;
		}

		return false;
	}

	/***********************************************************
	*	������������SID�ƍX�V���Ԃ��X�V
	*	�����F�X�V���̌�������
	***********************************************************/
	function setLoginInfo($strWhere, $uID){
		$set = $this->arrayReflasehData['strTime'] . '=?,';
		$set.= $this->arrayReflasehData['ip'] . '=?';

		$arrayData = array();

		array_push($arrayData, date('Y-m-d H:i:s'));
		array_push($arrayData, $_SERVER['REQUEST_ADDR']);
		array_push($arrayData, $uID);
		
		$this->setDataSimple($set, $strWhere, $arrayData);
	}

	/***********************************************************
	*	���O�A�E�g����
	*	�����F�Ȃ�
	***********************************************************/
	function setLogout(){

		$this->cDb->delData($this->arrayReflasehData['strSid'] . '=?' , array($this->getSession()), $this->strTableSession);
		$this->setSession('');
	}
}
?>