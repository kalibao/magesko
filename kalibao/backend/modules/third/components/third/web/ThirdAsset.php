<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license http://www.kalibao.com/license/
 */

namespace kalibao\backend\modules\third\components\third\web;

use kalibao\common\components\web\AssetBundle;

/**
 * Class ThirdAsset
 *
 * @package kalibao\backend\modules\mail\components\mailSendingRole\web
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class ThirdAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@kalibao/backend/modules/third/components/third/resources';

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
        'dist/js/kalibao.backend.third.ThirdEdit.js',
        'dist/js/kalibao.backend.third.ThirdList.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'kalibao\backend\components\web\AppAsset'
    ];
}