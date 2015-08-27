<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */


namespace kalibao\frontend\components\web;

use kalibao\common\components\web\AssetBundle;

/**
 * Class BootstrapAsset provide an asset bundle containing bootstrap resources
 *
 * @package kalibao\frontend\components\web
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class BootstrapAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $publishOptions = [
        //'forceCopy' => YII_ENV_DEV
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
        'yii\captcha\CaptchaAsset',
        'kalibao\frontend\components\web\AppAsset',
    ];
}