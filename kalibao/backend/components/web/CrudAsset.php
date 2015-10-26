<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\backend\components\web;

use kalibao\common\components\web\AssetBundle;

/**
 * Class CrudAsset
 *
 * @package kalibao\backend\components\web
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class CrudAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@kalibao/backend/components/resources/crud';

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
        'dist/styles/kalibao.backend.crud.main.css',
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'dist/js/kalibao.backend.crud.ListGrid.js',
        'dist/js/kalibao.backend.crud.Edit.js',
        'dist/js/kalibao.backend.crud.Setting.js',
        'dist/js/kalibao.backend.crud.Translate.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'kalibao\common\components\web\AppAsset',
        'kalibao\common\components\crud\CrudAsset',
    ];
}
