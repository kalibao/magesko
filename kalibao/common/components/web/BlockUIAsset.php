<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\web;

/**
 * Class BlockUIAsset provide an asset bundle containing the BlockUI resources (ajax loader).
 *
 * @package kalibao\common\components\web
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class BlockUIAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/blockui';

    /**
     * @inheritdoc
     */
    public $js = [
        'jquery.blockUI.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
