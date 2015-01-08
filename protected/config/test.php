<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
			'db'=>array(
				'class'=>'CDbConnection',
				'connectionString'=>'mysql:host=localhost;dbname=advokatmarket_test',
				'username'=>'root',
				'password'=>'',
				'charset' => 'utf8',
				'emulatePrepare'=>true,  // необходимо для некоторых версий инсталляций MySQL
			),
		),
	)
);
