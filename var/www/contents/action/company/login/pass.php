<?php
	
		$this->getCommon(true);
		
		$this->addLiblary(array('securty/Code'));		
		
		$SecurtyCode =  new SecurtyCode($this->arraySetting['secretKey']);
		
		$this->arrayUser['pass'] = $SecurtyCode->getEncode($this->arrayAll['pass']);
		
		
		$this->CompanyBase->commit($this->arrayUser);
		
		header('Location:' . $this->arrayAll['return']);
		exit();
?>