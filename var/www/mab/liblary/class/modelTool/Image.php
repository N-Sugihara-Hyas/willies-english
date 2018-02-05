<?php

		$self->addLiblary('file/Img');

		/*
		*	一時画像データからデータを取得して表示
		*	@params $cID セッションに確保してるID $sID セッションのID
		*/
		function viewSample($cID, $sID, $size=''){

			$ToolForm = new ToolForm($sID);
			$arraySession = $ToolForm->getDataSession();

			if (!empty($arraySession[$cID]['body'])){
				if (isset($self->arraySize[$size]) ){
					$size = $self->arraySize[$size];
				}else{
					$size = $self->arraySize['default'];
				}
					
				list($w, $h) = explode('*', $size);

				$FileImg = new FileImg($self->tmpName, $w, $h);
				$FileImg->setScale($arraySession[$cID]['body']);

				header("Content-type: image/jpeg");			
				imagejpeg($FileImg->arrayImgInfo['image']);
				exit();
			}
		}

		/*
		*	画像の表示
		*/
		$self->parent->view = function() use ($self){
			$self->addFile();

			$FileImg = new FileImg($self->fileName);
			$FileImg->getImgFile();
			$FileImg->viewShow();
		};

		$self->parent->viewResizeBinary = function($size, $body) use ($self){
			if ($body){
				$w = $h = 0;
				$size = $self->arraySize[$size];

				list($w, $h) = explode('x', $size);

				$FileImg = new FileImg('', $w, $h);
				$FileImg->setScale($body);
				$FileImg->viewShow();
			}else{
				$self->viewReSize($size);
			}
		};

		/*
		*	リサイズして、画像の表示
		*	@params $size サイズの種類の指定
		*/
		$self->parent->viewReSize = function($size) use ($self){
			$w = $h = 0;
			$size = $self->arraySize[$size];

			list($w, $h) = explode('x', $size);

			$self->addFile();

			$FileImg = new FileImg($self->fileName, $w, $h);
			$FileImg->setScale();
			$FileImg->setImgSave();
			$FileImg->viewShow();
		};


		/*
		*	画像生成
		*/
		$self->parent->addFile = function() use ($self){
			if (!file_exists($self->fileName)){
				$pos = strrpos($self->fileName, '/');
				$fileName = substr($self->fileName, $pos + 1, strlen($self->fileName));


				$self->addQuery('fileName', $fileName);
				$arrayImg = $self->getData()->getData();

				$fp = fopen($self->fileName, 'w');
				fwrite($fp, base64_decode($arrayImg['body']));
				fclose($fp);
				
				chmod($self->fileName, 0777);
			}
		};

		
?>