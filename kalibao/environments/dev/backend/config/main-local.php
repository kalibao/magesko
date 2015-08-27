<?php
$config = [
    'components' => [
        'cdnManager' => [
            'cdnBaseUrl' => [
                // cdn 1
                'http://static.kalibaoframework.lan',
            ]
        ],
        'assetManager' => [
            'forceCopy' => false,
        ],
        'request' => [
            // !!! This is required by cookie validation
            // !!! Must be different for each application. Do not store in version control system
            'cookieValidationKey' => '',
        ],
        'cache' => [
            'servers' => [
                [
                    'host' => 'localhost',
                    'port' => 11211,
                    'weight' => 100,
                ],
            ],
        ],
    ],
];

if (YII_DEBUG) {
    $config['modules']['generator'] = 'kalibao\common\modules\generator\Module';
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';
}

return $config;
