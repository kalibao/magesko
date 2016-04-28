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
     * @var boolean whether to automatically generate the needed language js files.
     * If this is true, the language js files will be determined based on the actual usage of [[DatePicker]]
     * and its language settings. If this is false, you should explicitly specify the language js files via [[js]].
     */
    public $autoGenerate = true;
    
    /**
     * @inheritdoc
     */
    public $sourcePath = '@kalibao/common/components/resources/adminLTE';

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
        'dist/css/AdminLTE.min.css',
        'plugins/datepicker/datepicker3.css',
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'dist/js/app.min.js',
        'plugins/datepicker/bootstrap-datepicker.js',
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