<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license http://www.kalibao.com/license/
 */

namespace kalibao\common\components\web;

/**
 * Class AdminLTEAsset provide an asset bundle containing AdminLTE resources.
 *
 * @package kalibao\backend\assets
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class AdminLTEAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@kalibao/common/components/resources/adminLTE';

    /**
     * @inheritdoc
     */
    public $publishOptions = [
        //'forceCopy' => YII_ENV_DEV
    ];

    /**
     * @inheritdoc
     */
    public $css = [
        'dist/css/AdminLTE.min.css',
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'dist/js/app.min.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'kalibao\common\components\web\Html5IE8SupportAsset',
        'kalibao\common\components\web\FontAwesomeAsset',
    ];
}