<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\product\components\product\web;

use kalibao\common\components\web\AssetBundle;

/**
 * Class MessageAsset
 *
 * @package kalibao\backend\modules\product\components\message\web
 * @version 1.0
 * @author Cassian Assael <cassian_as@yahoo.fr>
 */
class ProductAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@kalibao/backend/modules/product/components/product/resources';

    /**
     * @inheritdoc
     */
    public $publishOptions = [
        'forceCopy' => YII_ENV_DEV
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'dist/js/jquery.uploadfile.min.js',
        'dist/js/kalibao.backend.product.Product.js',
    ];

    /**
     * @inheritdoc
     */
    public $css = [
        'dist/css/kalibao.backend.product.css',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'kalibao\backend\components\web\AppAsset'
    ];
}