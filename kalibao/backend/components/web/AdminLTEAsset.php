<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license http://www.kalibao.com/license/
 */

namespace kalibao\backend\components\web;

/**
 * Class AdminLTEAsset provide an asset bundle containing main application resources
 *
 * @package kalibao\backend\components\web
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class AdminLTEAsset extends \kalibao\common\components\web\AdminLTEAsset
{
    /**
     * @inheritdoc
     */
    public $publishOptions = [
        //'forceCopy' => YII_ENV_DEV
    ];

    public function init()
    {
        $this->css = array_merge(
            $this->css,
            [
                'dist/css/skins/skin-blue.min.css',
            ]
        );
    }
}