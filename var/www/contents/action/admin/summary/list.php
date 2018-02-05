<?php
/*
*	トピックスリストの読み込み
*/

		//モデル情報の読み込み
		$this->addModel(array('member/Base', 'cource/Base', 'setting/Meta'));
		//共通処理
		$this->getCommon();

		$arrayCourceBase = $this->CourceBase->getData()->getDataAll();
		$arrayMemberState = $this->MemberBase->getFunctionData('MemberState');
		unset($arrayMemberState[999]);

		$arrayMember = array();

		foreach ($arrayCourceBase as $item){
			$this->SettingMeta->target = '*,cource_style.*';
			$this->SettingMeta->order = 'styleType ASC';
			$this->SettingMeta->joinCourceStyle();
			$this->SettingMeta->addQuery('setting_meta.id', 'arrayCourceStyle_' . $item['id']);
			$arrayCourceStyle = $this->SettingMeta->getData()->getDataAll();

			foreach ($arrayCourceStyle as $item2){

				foreach ($arrayMemberState as $key3 => $item3){
					$this->MemberBase->addQuery('cource_base_id', $item['id']);
					$this->MemberBase->addQuery('cource_style_id', $item2['id']);
					$this->MemberBase->addQuery('state', $key3);

					$arrayMember[$item['courceNameEnglish']][$item2['styleType']][$item3['id']] = $this->MemberBase->getData()->getCount();
				}
			}
		}

		$this->set('arrayMember', $arrayMember);
		$this->set('arrayMemberState', $arrayMemberState);
?>