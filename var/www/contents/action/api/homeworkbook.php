<?php

	$this->addModel(array('ext/HomeworkBook'));
	
	$this->ExtHomeworkBook->addQuery('cource_base_id', $this->arrayAll['cource_base_id']);
	$this->ExtHomeworkBook->addQuery('level', $this->arrayAll['level']);
	$dbGet = $this->ExtHomeworkBook->getDataType($this->arrayAll['type']);
	
	while ($item = $dbGet->getData()){
		echo $item['id'] . ',' . $item['title'] . "\n";
	}
	exit();

?>
