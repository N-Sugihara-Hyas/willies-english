<?php
/*
*	トピックスリストの読み込み
*/
	$this->addModel(array('take/ScheduleView', 'group/ReserveView'));

	$this->getCommon();

	$this->arrayAll['dateStart'] = date('Y-m-d');
	$this->arrayAll['dateEnd'] = date('Y-m-d', time() + (3600 * 24 * 7));
	
	$arraySet = $this->TakeScheduleView->setView($this->arrayAll, '', 'type2', $this->arrayUser['cource_base_id'], $this->arrayUser['skypeTime']);
	$arraySetGroup = $this->GroupReserveView->setView($this->arrayAll);
	
	foreach ($arraySet as $key => $item){
		if ($key == 'arrayTakeBase'){
			$this->set('arrayTake2', $item);		
		}else{
			$this->set($key, $item);
		}
	}
	foreach ($arraySetGroup as $key => $item){
		$this->set('group_' . $key, $item);
	}

	$this->TakeBase->addQuery('isView', 1);
	$this->set('arrayTake', $this->TakeBase->getData()->getDataAll());

	$this->set('allView', getVar($this->arrayAll, 'allView'));
	$this->set('isNotView', getVar($this->arrayAll, 'isNotView'));
	$this->set('isChange', getVar($this->arrayAll, 'isChange'));
?>