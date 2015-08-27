<?php
/**
 * Created by PhpStorm.
 * User: stagiaire
 * Date: 05/05/15
 * Time: 15:17
 */


namespace kalibao\backend\modules\third\components\address\web;

use kalibao\common\components\web\AssetBundle;

/**
 * Class CLientAsset
 *
 * @package kalibao\backend\modules\client\components\address\web
 */
class AddressAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@kalibao/backend/modules/third/components/address/resources';

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
        'dist/js/kalibao.backend.client.AddressList.js',
        'dist/js/kalibao.backend.client.AddressEdit.js',
        'dist/js/kalibao.backend.client.AddressSetting.js',
    ];
}