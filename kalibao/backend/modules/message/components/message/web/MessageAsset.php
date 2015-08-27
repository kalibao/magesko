<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license http://www.kalibao.com/license/
 */

namespace kalibao\backend\modules\message\components\message\web;

use kalibao\common\components\web\AssetBundle;

/**
 * Class MessageAsset
 *
 * @package kalibao\backend\modules\message\components\message\web
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class MessageAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@kalibao/backend/modules/message/components/message/resources';

    /**
     * @inheritdoc
     */
    public $publishOptions = [
        //'forceCopy' => YII_ENV_DEV
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'dist/js/kalibao.backend.message.Message.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'kalibao\backend\components\web\AppAsset'
    ];
}