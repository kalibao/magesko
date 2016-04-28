<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license http://www.kalibao.com/license/
 */

namespace kalibao\backend\components\web;

use kalibao\common\components\web\AssetBundle;

/**
 * Class AppAsset provide an asset bundle containing main application resources
 *
 * @package kalibao\backend\components\web
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class AppAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@kalibao/backend/components/resources/app';

    /**
     * @inheritdoc
     */
    public $publishOptions = [
        'forceCopy' => YII_ENV_DEV
    ];

    /**
     * @inheritdoc
     */
    public $css = [
        'dist/styles/kalibao.backend.main.css',
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'dist/js/kalibao.backend.App.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'kalibao\common\components\web\AppAsset',
    ];
}