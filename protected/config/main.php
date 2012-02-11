<?php

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Kajak',
    // preloading 'log' component
    'preload' => array('log'),
    'language'=>'pl',
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.models.User.*',
        'application.models.Misc.*',
        'application.models.Area.*',
        'application.models.Common.*',
        'application.models.DataSource.*',
        'application.models.Place.*',
        'application.models.Route.*',
        'application.models.Category.*',
        'application.components.*',
        'application.modules.rights.*',
        'application.modules.rights.components.*',
        'application.modules.dataexchange.components.*',
        'ext.YiiMongoDbSuite.*',
        'ext.YiiMongoDbSuite.components.*',
        'ext.YiiMongoDbSuite.test.*',
    ),
    'defaultController' => 'site',
    'modules' => array(
        'rights' => array(
            'debug' => true,
            //'install'=>true,
            'layout'=>'//layouts/admin-rights',
            'appLayout'=>'//layouts/admin',
            'superuserName'=>'Admin',
            'enableBizRuleData' => true,
            'userClass' => 'User',
            'userNameColumn' => 'email',
            'userIdColumn' => '_id',
            'checkPasswordDate' => false,
            'changePasswordUrl' => array('site/index'),
            'generatePasswordUrl' => array('site/index')
        ),
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'haslo',
            'generatorPaths' => array(
                'ext.YiiMongoDbSuite.gii',
                'ext.gii-haml'
            ),
            'newFileMode' => 0666,
            'newDirMode' => 0777,
        ),
        'dataexchange' => array(
            /*'formats' => array(
                'XML_kajak_org_pl',
                'wikimapia',
                'kajakorgpl'
            )*/
        ),
    ),
    // application components
    'components' => array(
        'CURL'=>array(
            'class'=>'CURL',
        ),
        'user' => array(
            'class' => 'EWebUser',
            'stateKeyPrefix' => 'mongodb',
            'allowAutoLogin' => true,
        ),
        'dbRights' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=kajak_rights',
            'username' => 'kajak',
            'password' => '6rQAVXYnz7spUqr4',
            'charset' => 'utf8',
            'tablePrefix' => '',
        ),
        'mongodb' => array(
            'class' => 'EMongoDB',
            'connectionString' => 'mongodb://localhost',
            'dbName' => 'kajak',
            'fsyncFlag' => true,
            'safeFlag' => true,
            'useCursor' => true
        ),
        'assetManager' => array(
            'class' => 'ext.phamlp.PBMAssetManager',
            'parsers' => array(
                'scss' => array(
                    'class' => 'ext.phamlp.Sass',
                    'output' => 'css',
                    'options' => array(
                        'style' => 'nested',
                        'cache' => false,
                        'extensions' => array(
                            'compass' => array(
                                'project_path' => realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..'),
                                'relative_assets' => false,
                            ),
                        )
                    )
                ),
            )
        ),
        'viewRenderer' => array(
            'class' => 'ext.phamlp.Haml',
            // delete options below in production
            'ugly' => false,
            'style' => 'compressed',
            'debug' => 0,
            'cache' => false,
            'fileExtension' => '.haml',
            'viewFileExtension' => '.php5',
            'useRuntimePath' => false,
            'helperFile' => 'ext.phamlp.helper.Helpers',
        ),
        'filters' => array(
            'class' => 'ext.filters.GFilters',
            'map' => array(
                'slider' => 'ext.filters.slider.GFSlider',
                'dropdown' => 'ext.filters.dropdown.GFDropDown',
                'text' => 'ext.filters.text.GFText',
                'textarea' => 'ext.filters.textarea.GFTextArea',
            ),
        ),
        'authManager' => array(
            'class' => 'RDbAuthManager',
            'connectionID' => 'dbRights',
            'itemTable' => 'authitem',
            'itemChildTable' => 'authitemchild',
            'assignmentTable' => 'authassignment',
            'rightsTable' => 'rights',
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
            ),
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                 array(
                    'class'=>'CProfileLogRoute',
                    'report'=>'summary',
                ),
            ),
        ),
        'cache'=> array(
            'class'=>'EMongoDBCache',
            //'mongoConnectionId' => 'mongodb', // (default) configId from YiiMongoDbSuite
            //'collectionName' => 'mongodb_cache', // (default)
            //set to false after first use of the cache to increase performance
            'ensureIndex' => false,
        )
    ),
);