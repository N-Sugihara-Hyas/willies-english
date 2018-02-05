<?php

		/*
		 * どこでしったかの取得
		 */
		function getSelectLevelChild($model){
			return
				array(
				'0' => array('id' => 0, 'level' => 0, 'value' => 'This is Phonics：英語を初めて学習する方。A, B, C...の発音練習を中心に簡単な単語を習います。', 'view' => 'This is Phonics'),
				'1' => array('id' => 1, 'level' => 1, 'value' => 'WE CAN! Book 1 : アルファベット、挨拶、Do you..?　など簡単な会話を習います。', 'view' => 'WE CAN! Book 1'),
				'2' => array('id' => 2, 'level' => 2, 'value' => 'WE CAN! Book 2 : （英検5-4級） I am…/ I can…や、on/ in/ underなどの前置詞を使った表現を習います。', 'view' => 'WE CAN! Book 2'),
				'3' => array('id' => 3, 'level' => 3, 'value' => 'WE CAN! Book 3 : （英検4級） She.. He..の肯定文、Do/ Doesの質問文、比較級/ 最上級を使った表現を習います。', 'view' => 'WE CAN! Book 3'),
				'4' => array('id' => 4, 'level' => 4, 'value' => 'WE CAN! Book 4 : （英検3級） What/When/Which/How などの質問文、一般動詞や過去形を使った表現を習います。', 'view' => 'WE CAN! Book 4'),
				'5' => array('id' => 5, 'level' => 5),
				'6' => array('id' => 6, 'level' => 6),
				'7' => array('id' => 7, 'level' => 7),

				'1001' => array('id' => 1001, 'level' => 1, 'value' => 'L1: キクタン キッズ［初級編］（Kiku Tan Kids 1）：　初めて英語に触れるお子様向け。果物、野菜、食べ物などの単語を身につけます', 'view' => 'Kiku Tan Kids 1'),
				'1002' => array('id' => 1002, 'level' => 2, 'value' => 'L2: キクタン キッズ［中級編］（Kiku Tan Kids 2）：　英語経験1年程度。学校や食べ物、時間などの単語を身につけます', 'view' => 'Kiku Tan Kids 2'),
				'1003' => array('id' => 1003, 'level' => 3, 'value' => 'L3: キクタン キッズ［上級編］（Kiku Tan Kids 3）：　英語経験2年程度。身のまわり、学校、行事などの単語を身につけます', 'view' => 'Kiku Tan Kids 3'),
				'1004' => array('id' => 1004, 'level' => 4, 'value' => 'L4: キクタン 小学生［1］（Kiku Tan Elementary 1）：　英語経験2年程度。好きなもの、誕生日などに関する表現を身につけます', 'view' => 'Kiku Tan Elementary 1'),
				'1005' => array('id' => 1005, 'level' => 5, 'value' => 'L5: キクタン 小学生［２］（Kiku Tan Elementary 2）：　英語経験2年程度。身のまわりや季節などに関する表現を身につけます', 'view' => 'Kiku Tan Elementary 2'),
			);
		}


?>
