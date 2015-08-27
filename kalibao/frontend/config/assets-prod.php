<?php
return [
    'kalibao\frontend\components\web\BootstrapAssetCompressed' => [
        'class' => 'kalibao\common\components\web\AssetBundle',
        'basePath' => '@webroot/assets-compressed',
        'baseUrl' => 'assets-compressed',
        'js' => [
            'js/frontend-f259382da6878012549ef25d05bf356c.js',
        ],
        'css' => [
            'css/frontend-bfb0eea30f6dbd6bbe4ef1a60eb00f8d.css',
        ],
    ],
    'kalibao\frontend\components\web\BootstrapAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'kalibao\frontend\components\web\BootstrapAssetCompressed',
        ],
    ],
    'yii\web\JqueryAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'kalibao\frontend\components\web\BootstrapAssetCompressed',
        ],
    ],
    'yii\web\YiiAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'kalibao\frontend\components\web\BootstrapAssetCompressed',
        ],
    ],
    'yii\jui\JuiAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'kalibao\frontend\components\web\BootstrapAssetCompressed',
        ],
    ],
    'yii\validators\ValidationAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'kalibao\frontend\components\web\BootstrapAssetCompressed',
        ],
    ],
    'yii\captcha\CaptchaAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'kalibao\frontend\components\web\BootstrapAssetCompressed',
        ],
    ],
    'yii\widgets\ActiveFormAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'kalibao\frontend\components\web\BootstrapAssetCompressed',
        ],
    ],
];