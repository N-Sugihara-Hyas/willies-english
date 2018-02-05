<?php

/*
*	GPSの計算
*/
class MobileGPS{
var $carrierNo;

	/***********************************************************
	*	�R���X�g���N�^
	*	�f�o�b�N���[�h,�e�[�u����,�Z�b�V�����̖���
	***********************************************************/
	function MobileGPS($carrierNo){
		$this->carrierNo = $carrierNo;
	}

	/***********************************************************
	*	GPS�̈ܓx�o�x�̎擾
	*	��:GET,POST�l
	***********************************************************/
	function getForLat($data){
		if ($this->carrierNo == 1){
			$this->arrayData['lat'] = $data['lat'];
			$this->arrayData['lng'] = $data['lon'];
		}

		if ($this->carrierNo == 2){
			$this->arrayData['lat'] = $data['lat'];
			$this->arrayData['lng'] = $data['lon'];
		}

		//�ܓx�o�x��Google�`���ɕϊ�
		$arrayLat = explode('.', $this->arrayData['lat']);
		$arrayLng = explode('.', $this->arrayData['lng']);

		$this->arrayData['lat'] = $arrayLat[0] + ($arrayLat[1]/ 60) + (($arrayLat[2] + ($arrayLat[3] / 1000)) / 3600 );
		$this->arrayData['lng'] = $arrayLng[0] + ($arrayLng[1]/ 60) + (($arrayLng[2] + ($arrayLng[3] / 1000)) / 3600 );

		return $this->arrayData;
	}

	/***********************************************************
	*	GPS�̃����N�̎擾
	*	��:��ѐ��URL
	***********************************************************/
	function getLink($url){
		if ($this->carrierNo == 1){
			return '<a href="' . $url . '" lcs>';
		}
		if ($this->carrierNo == 2){
			return '<a href="device:location?url=' . $url . '">';
		}
	}

}

?>