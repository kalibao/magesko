<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\web;

/**
 * Class AppAsset provide an asset bundle containing main application resources.
 *
 * @package kalibao\common\components\web
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class AppAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@kalibao/common/components/resources/core';

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
        'dist/styles/kalibao.core.app.css',
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'dist/js/kalibao.core.app.js',
        'dist/js/kalibao.core.tools.js',
        'dist/js/kalibao.core.Modal.js',
        'dist/js/kalibao.core.Uploader.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\widgets\ActiveFormAsset',
        'yii\validators\ValidationAsset',
        'kalibao\common\components\web\JuiAsset',
        'kalibao\common\components\web\BlockUIAsset',
    ];
}
