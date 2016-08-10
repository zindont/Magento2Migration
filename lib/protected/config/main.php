<?php
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return CMap::mergeArray(
    require(dirname(__FILE__) . '/config.php'), array(

        'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
        'name'=>'Migrate Data From Magento 1.x to Magento 2.x',

        // preloading 'log' component
        'preload'=>array('log'),

        'defaultController'=>'migrate',

        // application components
        'components'=>array(
            'user'=>array(
                // enable cookie-based authentication
                'allowAutoLogin'=>true,
            ),

            'errorHandler'=>array(
                'errorAction'=>'migrate/error',
            ),
            'urlManager'=>array(
                'urlFormat'=>'path',
                'rules'=>array(
                    '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                ),
            ),
            'log'=>array(
                'class'=>'CLogRouter',
                'routes'=>array(
                    array(
                        'class'=>'CFileLogRoute',
                        //'levels'=>'error, warning, info',
                        'levels'=>'error, warning',
                        //'levels'=>'error',
                    ),
                    // uncomment the following to show log messages on web pages
//                    array(
//                        'class'=>'CWebLogRoute',
//                    ),
                ),
            ),

            //Database of tool
//            'db' => array(
//                'connectionString' => 'mysql:host=localhost;dbname=ub_tool',
//                'emulatePrepare' => true,
//                'username' => 'root',
//                'password' => '',
//                'charset' => 'utf8',
//                'tablePrefix' => 'ub_',
//                'class' => 'CDbConnection'
//            ),
            'db'=>array(
                'connectionString' => 'sqlite:protected/data/ub_tool.db',
                'tablePrefix' => 'ub_',
            ),
            'cache'=>array( 
                'class' => 'CFileCache'
            )
        ),

        // auto loading model and component classes
        'import'=>array(
            'application.components.*',
            'application.models.*',
            'application.models.db.*',
            'application.models.db.mage2.*',
            'application.models.mage2.*',
            'application.models.mage1.*'
        ),

        // application-level parameters that can be accessed
        // using Yii::app()->params['paramName']
        'params'=> array(
            // this is displayed in the header section
            'title'=>'WiseDataMigration - WiseRobot',
            // this is used in error pages
            'adminEmail'=>'an.ho1991@gmail.com',
            // the copyright information displayed in the footer section
            'copyrightInfo'=>'Copyright &copy; 2016 by WiseRobot',
        )
    )
);
