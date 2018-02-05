<?php

require_once dirname(__FILE__) . '/../../PEAR/Archives/Archive.php';

/***********************************************************
*	ZIPの解凍
***********************************************************/
	class FileArchive{
		var $fileName;						/*ZIP名*/

		/***********************************************************
		*	
		***********************************************************/
		function FileArchive($fileName){
			$this->fileName = $fileName;
		}

		function getData($dir){

			File_Archive::extract(
	  			File_Archive::read($this->fileName . '/'),
				File_Archive::appender($dir)
			);
		
		}

		function outData($dir){
			File_Archive::extract(
			  File_Archive::read($this->fileName . '/'),
			  File_Archive::toArchive($dir, File_Archive::toOutput())
			);
		}

}