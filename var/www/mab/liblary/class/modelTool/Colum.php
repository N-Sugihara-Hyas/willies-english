<?php

		/*
		 * getFunctionData���J�����P�ʂœǂݍ���
		*/
		$self->parent->getFunctionDataColum = function() use ($self){
			foreach ($self->arrayColum as $key => $item){
				if (isset($self->arrayColum[$key]['data']) ){
					$self->arrayColum[$key]['data'] = $self->getFunctionData($self->arrayColum[$key]['data']);
				}
			}
		};

		/*
		 * �Ώۂ̃f�[�^���L�[��getFunctionDataOwn���J�����P�ʂœǂݍ���
		*/
		$self->parent->getFunctionDataOwnColum = function($arrayInput) use ($self){
			foreach ($self->arrayColum as $key => $item){
				if (isset($self->arrayColum[$key]['data']) ){
					if (isset($arrayInput[$key])){
						$arrayInput[$key] = $self->getFunctionDataOwn($self->arrayColum[$key]['data'], $arrayInput[$key]);
					}
				}
			}

			return $arrayInput;
		};
?>
