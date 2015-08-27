<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'kalibao.frontend',
    'name' => 'Frontend',
    'version' => '1.0',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'kalibao\backend\modules\site\controllers',
    'defaultRoute' => 'cms/cms/index',
    'modules' => [
        'site' => [
            'class' => 'kalibao\frontend\modules\site\Module',
        ],
        'cms' => [
            'class' => 'kalibao\frontend\modules\cms\Module',
        ],
        'contact' => [
            'class' => 'kalibao\frontend\modules\contact\Module',
        ],
        'news' => [
            'class' => 'kalibao\frontend\modules\news\Module',
        ],
    ],
    'bootstrap' => [
        'cms',
        'contact',
        'news'
    ],
    'components' => [
        'urlManager' => [
            'class' => 'kalibao\backend\components\web\UrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
        ],
        'appLanguage' => [
            'languageGroupName' => 'kalibao.frontend'
        ],
        'assetManager' => [
            'bundles' => YII_ENV_DEV ? require __DIR__ . '/assets-dev.php' : require __DIR__.'/assets-prod.php',
        ],
        'cdnManager' => [
            //'cdnBaseUrl' => []  Configuration must be set in local configuration file
        ],
        'i18n' => [
            'translations' => [
                'kalibao.frontend' => [
                    'class' => 'kalibao\common\components\i18n\DbMessageSource'
                ]
            ]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'cache' => [
            'keyPrefix' => 'kalibao.frontend.cache',
            'servers' => [], // Configuration must be set in local configuration file
        ],
        'errorHandler' => [
            'errorAction' => 'site/site/error',
        ],
    ],
    'params' => $params,
];
