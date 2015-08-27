<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

// In the console environment, some path aliases may not exist.
Yii::setAlias('@webroot', __DIR__ . '/../web');
Yii::setAlias('@web', '/');

return [
    // The list of asset bundles to compress:
    'groupsAssets' => [
        [
            'assets' => [
                'kalibao\backend\components\web\BootstrapAsset' => true,
            ],
            'outputFile' => 'backend-{hash}',
            'outputBasePath' => '@webroot/assets-compressed',
        ],
        /*[
            'assets' => [
                'OTHER' => false,
            ],
            'outputFile' => 'other-{hash}',
            'outputBasePath' => '@webroot/assets-compressed',
        ]*/
    ],
    // Asset manager configuration:
    'assetManager' => [
        'basePath' => '@webroot/assets',
        'baseUrl' => '../../assets',
    ],
];