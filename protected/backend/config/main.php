<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$backend=dirname(dirname(__FILE__));
$frontend=dirname($backend);
Yii::setPathOfAlias('backend', $backend);
 
return array(
    'basePath' => $frontend,
    'name' => 'ARLAB TI - Portal de Clientes',
    'controllerPath' => $backend.'/controllers',
    'viewPath' => $backend.'/views',
    'runtimePath' => $backend.'/runtime',
 
    'import' => array(
        'backend.models.*',
        'backend.components.*',
        'application.models.*',
        'application.components.*',
    ),
    // ... other configurations ...
    'modules' => array(
        // uncomment the following to enable the Gii tool
        'cal' => array(
            'debug' => true, //create tables, need for first run only!
            'layout' => 'column2', //optional, not required
        ),
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'pascal098deal',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
        'auditTrail' => array(),
    ),
    'language' => 'es', // Este es el lenguaje en el que querés que muestre las cosas
    'sourceLanguage' => 'en', // este es el lenguaje por default de los archivos
    // application components
    'preload'=>array('log'),
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'class' => 'WebUser',
            'allowAutoLogin' => true,
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        /*
          'db'=>array(
          'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
          ),
         */
        // uncomment the following to use a MySQL database
        'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				'web'=>array(
					'class'=>'CWebLogRoute',
					'levels'=>'trace, info, error, warning',
					'categories'=>'system.db.*',
					'showInFireBug'=>false //true/falsefirebug only - turn off otherwise
				),
			),
		),
        'db' => array(
            'connectionString' => 'mysql:host=127.0.0.1;dbname=arlabsysdevel',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'eLaStIx.2oo7',
            'charset' => 'utf8',
            'enableProfiling' => true,
            'enableParamLogging' => true,
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
       
        'clientScript' => array(
            'class' => 'ext.nlacsoft.NLSClientScript',
            'hashMode' => 'PATH', //PATH|CONTENT
            'bInlineJs' => false
        ),
        'session' => array(
            'timeout' => 300,
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'gabriel@arlab.com.ar',
        'generaDebitos' => true,
        'descontarStock' => true,
        'cotizacionDolar' => '4.65',
        'cuentaCajaDiaria' => '1',
        'cuentaCajaMayor' => '2',
    ),
  
);