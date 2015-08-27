<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license http://www.kalibao.com/license/
 */

namespace kalibao\backend\modules\cms\components\cmsImage\web;

use kalibao\common\components\web\AssetBundle;

/**
 * Class CmsPageAsset
 *
 * @package kalibao\backend\modules\cms\components\cmsPage\web
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class CmsImageAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@kalibao/backend/modules/cms/components/cmsImage/resources';

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
        'dist/css/kalibao.backend.cms.cms-image.css',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'kalibao\backend\components\web\AppAsset'
    ];
}