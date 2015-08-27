<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license http://www.kalibao.com/license/
 */

namespace kalibao\common\components\web;

/**
 * Class FontAwesomeAsset provide an asset bundle containing the iconic font and CSS toolkit
 *
 * @package kalibao\backend\assets
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class FontAwesomeAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@kalibao/common/components/resources/fontAwesome';

    /**
     * @inheritdoc
     */
    public $css = [
        'css/font-awesome.css',
    ];

}