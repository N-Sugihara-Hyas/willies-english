<?php

		/*
		 * getFunctionDataをカラム単位で読み込む
		*/
		$self->parent->getFunctionDataColum = function() use ($self){
			foreach ($self->arrayColum as $key => $item){
				if (isset($self->arrayColum[$key]['data']) ){
					$self->arrayColum[$key]['data'] = $self->getFunctionData($self->arrayColum[$key]['data']);
				}
			}
		};

		/*
		 * 対象のデータをキーにgetFunctionDataOwnをカラム単位で読み込む
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
