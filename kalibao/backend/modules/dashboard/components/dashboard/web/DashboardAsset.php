<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license http://www.kalibao.com/license/
 */

namespace kalibao\backend\modules\dashboard\components\dashboard\web;

use kalibao\common\components\web\AssetBundle;

/**
 * Class DashboardAsset
 *
 * @package kalibao\backend\modules\dashboard\components\dashboard\web
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class DashboardAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@kalibao/backend/modules/dashboard/components/dashboard/resources';

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
        'dist/css/kalibao.backend.dashboard.css',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'kalibao\backend\components\web\AppAsset'
    ];
}