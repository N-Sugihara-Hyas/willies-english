<?php

/***********************************************************
*	CSV�֘A�̃N���X
*/
class classCSV{
var $fileName;
var $csv;
var $arrayData;

	/***********************************************************
	*	�R���X�g���N�^
	*	$flgType 1=�t�@�C���œǂݍ��� 2=�f�[�^�œǂݍ��� 3=POST����ǂݍ���
	*/
	function classCSV($flgType=1, $value=''){
		if ($flgType == 3){
			$this->fileName = $_FILES[$value]['tmp_name'];
		}else if($flgType == 2){
			$this->csv = $value;
		}else{
			$this->fileName = $value;
		}
	}

	/***********************************************************
	*	�f�[�^�̐ݒ�
	*/
	function setData($data){
		$this->csv = $data;
	}

	/***********************************************************
	*	�f�[�^�̕ϊ�
	*/
	function changeData(){
		$this->arrayData = explode(',', $this->csv);

		return $this->arrayData;
	}

}