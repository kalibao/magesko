<?php
return [
    'vendorPath' => dirname(dirname(dirname(__DIR__))) . '/vendor',
    'language' => 'fr',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',

            // server status
            'serverRetryInterval' => 600,
            'serverStatusCache' => 'commonCache',

            // schema cache
            'enableSchemaCache' => true,
            'schemaCache' => 'commonCache',
            'schemaCacheDuration' => 0, // 0 = never expire

            // query cache component
            'queryCache' => 'commonCache',
            'queryCacheDuration' => 60, // default cache duration

            // configuration for the master
            'dsn' => '',
            'username' => '',
            'password' => '',
            'charset' => 'utf8',

            // common configuration for slaves
            'slaveConfig' => [
                'username' => '',
                'password' => '',
                'charset' => 'utf8',
                'attributes' => [
                    // use a smaller connection timeout
                    PDO::ATTR_TIMEOUT => 10,
                ],
            ],

            // list of slave configurations
            'slaves' => [],
        ],
        'appLanguage' => [
            'class' => 'kalibao\common\components\i18n\ApplicationLanguage',
            'languageGroupName' => 'common'
        ],
        'view' => [
            'class' => 'kalibao\common\components\base\View',
        ],
        'cdnManager' => [
            'class' => 'kalibao\common\components\web\CdnManager',
            'cdnBaseUrl' => []
        ],
        'assetManager' => [
            'class' => 'kalibao\common\components\web\AssetManager',
            'basePath' => '@webroot/assets',
            'baseUrl' => 'assets',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'messageClass' => 'kalibao\common\components\mail\Message',
        ],
        'user' => [
            'class' => 'kalibao\common\components\web\User',
            'identityClass' => null, // Must be implemented for each application
        ],
        'session' => [
            'class' => 'yii\web\CacheSession',
            'cache' => 'cache',
        ],
        'i18n' => [
            'class' => 'kalibao\common\components\i18n\I18N',
            'translations' => [
                'kalibao' => [
                    'class' => 'kalibao\common\components\i18n\DbMessageSource'
                ]
            ]
        ],
        'interfaceSettings'  => [
            'class' => 'kalibao\common\components\crud\InterfaceSettings',
        ],
        'variable' => [
            'class' => 'kalibao\common\components\variable\Variable',
        ],
        'cache' => [
            'class' => 'kalibao\common\components\caching\MemCached',
            // Must be implemented for each application. APP_NAME should be replaced by application name
            //'keyPrefix' => 'kalibao.APP_NAME.cache',
            //'servers' => [], // Configuration must be set in local configuration file
        ],
        'commonCache' => [
            'class' => 'kalibao\common\components\caching\MemCached',
            'keyPrefix' => 'kalibao.common.cache',
            'servers' => [], // Configuration must be set in local configuration file
        ],
    ],
];
