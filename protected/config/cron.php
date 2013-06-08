<?php
return array(
    // This path may be different. You can probably get it from `config/main.php`.
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'Cron',
 
    'preload'=>array('log'),
 
    'import'=>array(
        'application.components.*',
        'ext.YiiMailer.YiiMailer',
        'application.models.*',
    ),
    // We'll log cron messages to the separate files
    'components'=>array(
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'logFile'=>'cron.log',
                    'levels'=>'error, warning',
                ),
                array(
                    'class'=>'CFileLogRoute',
                    'logFile'=>'cron_trace.log',
                    'levels'=>'trace',
                ),
            ),
        ),
 
        // Your DB connection
         'db' => array(
            'connectionString' => 'mysql:host=127.0.0.1;dbname=arlabsysdevel',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'eLaStIx.2oo7',
            'charset' => 'utf8',
            'enableProfiling' => true,
            'enableParamLogging' => true,
        ),
    ),
);
?>