<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\frontend\components\web;

use kalibao\common\components\web\AssetBundle;

/**
 * Class AppAsset provide an asset bundle containing main application resources
 *
 * @package kalibao\frontend\components\web
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class AppAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@kalibao/frontend/components/resources/app';

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
        'dist/css/clean-blog.css',
    ];
}