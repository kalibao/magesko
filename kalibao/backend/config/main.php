<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'kalibao.backend',
    'name' => 'Backend',
    'version' => '1.0',
    'bootstrap' => ['log'],
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'kalibao\backend\modules\site\controllers',
    'defaultRoute' => 'dashboard/dashboard/index',
    'modules' => [
        'site' => [
            'class' => 'kalibao\backend\modules\site\Module',
        ],
        'authentication' => [
            'class' => 'kalibao\backend\modules\authentication\Module',
        ],
        'dashboard' => [
            'class' => 'kalibao\backend\modules\dashboard\Module',
        ],
        'profile' => [
            'class' => 'kalibao\backend\modules\profile\Module',
        ],
        'message' => [
            'class' => 'kalibao\backend\modules\message\Module'
        ],
        'variable' => [
            'class' => 'kalibao\backend\modules\variable\Module',
        ],
        'rbac' => [
            'class' => 'kalibao\backend\modules\rbac\Module',
        ],
        'language' => [
            'class' => 'kalibao\backend\modules\language\Module',
        ],
        'mail' => [
            'class' => 'kalibao\backend\modules\mail\Module',
        ],
        'cms' => [
            'class' => 'kalibao\backend\modules\cms\Module',
        ],
        'cache' => [
            'class' => 'kalibao\backend\modules\cache\Module',
        ],
        'demo' => [
            'class' => 'kalibao\backend\modules\demo\Module',
        ],
        'product' => [
            'class' => 'kalibao\backend\modules\product\Module',
        ],
        'media' => [
            'class' => 'kalibao\backend\modules\media\Module',
        ],
        'attribute-type' => [
            'class' => 'kalibao\backend\modules\attributeType\Module',
        ],
        'attribute' => [
            'class' => 'kalibao\backend\modules\attribute\Module',
        ],
        'logistic-strategy' => [
            'class' => 'kalibao\backend\modules\logisticStrategy\Module',
        ],
        'brand' => [
            'class' => 'kalibao\backend\modules\brand\Module',
        ],
        'supplier' => [
            'class' => 'kalibao\backend\modules\supplier\Module',
        ],
        'third' => [
            'class' => 'kalibao\backend\modules\third\Module',
        ],
        'tree' => [
            'class' => 'kalibao\backend\modules\tree\Module',
        ],
    ],
    'components' => [
        'request' => [
            'class' => 'yii\web\Request',
            'enableCookieValidation' => true,
            'cookieValidationKey' => null, // Configuration must be set in local configuration file
            'enableCsrfValidation' => true,
            'enableCsrfCookie' => true,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'urlManager' => [
            'class' => 'kalibao\backend\components\web\UrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
        ],
        'appLanguage' => [
            'languageGroupName' => 'kalibao.backend'
        ],
        'authUserManager' => [
            'class' => 'kalibao\common\components\rbac\RBACUserManager',
        ],
        'assetManager' => [
            'bundles' => YII_ENV_DEV ? require __DIR__ . '/assets-dev.php' : require __DIR__.'/assets-prod.php',
        ],
        'cdnManager' => [
            //'cdnBaseUrl' => []  Configuration must be set in local configuration file
        ],
        'user' => [
            'class' => 'kalibao\backend\components\web\User',
            'identityClass' => 'kalibao\backend\components\web\UserIdentity',
        ],
        'cache' => [
            'keyPrefix' => 'kalibao.backend.cache',
            'servers' => [], // Configuration must be set in local configuration file
        ],
        'i18n' => [
            'translations' => [
                'kalibao.backend' => [
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
        'errorHandler' => [
            'errorAction' => 'site/site/error',
        ],
    ],
    'params' => $params,
];
