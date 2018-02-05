<?php
	class ToolGoogleMap{

		function ToolGoogleMap(){

		}

		/*
		*	住所から緯度経度データの取得
		*/
		function getNameForGeo($areaName){
			$url = 'http://maps.googleapis.com/maps/api/geocode/xml?sensor=false&region=jp&address=' . $areaName;
			$res = simplexml_load_file($url);

			if (isset($res->result->geometry->location->lng)){
				$this->geo['lat'] = $res->result->geometry->location->lat;
				$this->geo['lng'] = $res->result->geometry->location->lng;

				return $this->geo;
			}else{
				return false;
			}
		}

		/*
		*	緯度経度から住所データの取得
		*/
		function getGeoForName($lat, $lng){
			$url = 'http://maps.google.com/maps/geo?ll=' . $lat . ',' . $lng . '&output=xml&hl=ja&oe=UTF8';
			$res = simplexml_load_file($url);

			$this->arrayArea = $res->Response->Placemark;

			return $this->arrayArea;
		}

		/*
		*	住所データから住所と郵便番号の取得
		*/
		function getAddress($arrayArea=''){
			if (!$arrayArea){$arrayArea = $this->arrayArea;}

			foreach ($this->arrayArea as $item){
				if (!empty($item->AddressDetails->Country->AdministrativeArea->Locality->DependentLocality->PostalCode->PostalCodeNumber)){
					$this->arrayAreaDetils['zip'] = $item->AddressDetails->Country->AdministrativeArea->Locality->DependentLocality->PostalCode->PostalCodeNumber;
				}else{
					if (!isset($this->arrayAreaDetils['address'])){
						if (strpos($item->address, '〒')===FALSE){
							$this->arrayAreaDetils['address'] = $item;
						}
					}
				}
			}

			return $this->arrayAreaDetils;
		}

	}
?>