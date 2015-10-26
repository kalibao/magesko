<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\modules\tree\components\tree\web;

use kalibao\common\components\web\AssetBundle;

/**
 * Class TreeAsset
 *
 * @package kalibao\backend\modules\tree\components\tree\web
 * @version 1.0
 * @author Cassian Assael <cassian_as@yahoo.fr>
 */
class TreeAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@kalibao/backend/modules/tree/components/tree/resources';

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
        'dist/js/jstree.min.js',
        'dist/js/kalibao.backend.tree.Tree.js',
    ];

    /**
     * @inheritdoc
     */
    public $css = [
        'dist/css/style.css',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'kalibao\backend\components\web\AppAsset'
    ];
}