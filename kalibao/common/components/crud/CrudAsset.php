<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\crud;

use kalibao\common\components\web\AssetBundle;

/**
 * Class CrudAsset
 *
 * @package kalibao\common\components\web
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class CrudAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@kalibao/common/components/resources/crud';

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
        'dist/styles/kalibao.crud.main.css',
        'plugins/select2/select2.css',
        'plugins/select2/select2-bootstrap.css',
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'dist/js/kalibao.crud.ListGrid.js',
        'dist/js/kalibao.crud.Edit.js',
        'dist/js/kalibao.crud.Setting.js',
        'dist/js/kalibao.crud.Translate.js',
        'dist/js/kalibao.crud.tools.js',
        'plugins/select2/select2.crud.3.5.2.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'kalibao\common\components\web\AppAsset',
        'kalibao\common\components\web\CKEditorAsset',
    ];
}
