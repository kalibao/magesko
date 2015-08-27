<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license http://www.kalibao.com/license/
 */

namespace kalibao\common\components\web;

/**
 * Class Html5IE8SupportAsset provide an asset bundle containing support files for IE8
 *
 * @package kalibao\backend\assets
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class Html5IE8SupportAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@kalibao/common/components/resources/ie8Support';

    /**
     * @inheritdoc
     */
    public $jsOptions = ['condition' => 'lte IE9'];

    /**
     * @inheritdoc
     */
    public $js = [
        'html5shiv/html5shiv.js',
        'respond/respond.js',
    ];
}