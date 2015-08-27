<?php
return [
    'kalibao\backend\components\web\BootstrapAssetCompressed' => [
        'class' => 'kalibao\common\components\web\AssetBundle',
        'basePath' => '@webroot/assets-compressed',
        'baseUrl' => 'assets-compressed',
        'js' => [
            'js/backend-.js',
        ],
        'css' => [
            'css/backend-.css',
        ],
    ],
    'kalibao\backend\components\web\BootstrapAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'kalibao\backend\components\web\BootstrapAssetCompressed',
        ],
    ],
    'yii\web\JqueryAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'kalibao\backend\components\web\BootstrapAssetCompressed',
        ],
    ],
    'yii\web\YiiAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'kalibao\backend\components\web\BootstrapAssetCompressed',
        ],
    ],
    'yii\jui\JuiAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'kalibao\backend\components\web\BootstrapAssetCompressed',
        ],
    ],
    'yii\validators\ValidationAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'kalibao\backend\components\web\BootstrapAssetCompressed',
        ],
    ],
    'yii\widgets\ActiveFormAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'kalibao\backend\components\web\BootstrapAssetCompressed',
        ],
    ]
];