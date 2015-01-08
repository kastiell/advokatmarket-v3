<?php

//Путь к подключению пакетов
$packages = require_once(dirname(__FILE__).'/packages.php');

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	
	//Меняем расположение стандартного контроллера
	'defaultController'=>'main/index/index',
	
	'name'=>'ADVOKATMARKET',
	
	//Меняем расположение стандартного layout
	'layoutPath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'main'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'layouts',	
	//Меняем расположение стандартного view
	'viewPath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'main'.DIRECTORY_SEPARATOR.'views',
	
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.models.db.*',
		'application.components.*',
	),

	'modules'=>array(
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'admin',
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'main',
        'profile',
        'admin',

	),

	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
            'class' => 'WebUser',
			'allowAutoLogin'=>true,
            'loginUrl'=>array('/main/registry/login'),
		),

        'authManager' => array(
            // Будем использовать свой менеджер авторизации
            'class' => 'PhpAuthManager',
            // Роль по умолчанию. Все, кто не админы, модераторы и юзеры — гости.
            'defaultRoles' => array('guest'),
        ),

        //Регестрируем пакеты ресурсов
        'clientScript'=>array(
            'packages'=>$packages,
        ),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		'db'=>array(
			'class'=>'CDbConnection',
            'connectionString'=>'mysql:host=localhost;dbname=advokatmZK',
            'username'=>'root',
            'password'=>'',
			'charset' => 'utf8',
            'emulatePrepare'=>true,  // необходимо для некоторых версий инсталляций MySQL
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'main/registry/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		'adminEmail'=>'webmaster@example.com',
	    'maskPhone'=>'+38(099)999-99-99',
	    'emptyFind'=>'По вашему запросу ничего не найдено',
	    'day2pay'=>2,
    ),
);