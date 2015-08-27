<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license http://www.kalibao.com/license/
 */

namespace kalibao\backend\modules\cms\components\cmsPage\web;

use kalibao\common\components\web\AssetBundle;

/**
 * Class CmsPageAsset
 *
 * @package kalibao\backend\modules\cms\components\cmsPage\web
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class CmsPageAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@kalibao/backend/modules/cms/components/cmsPage/resources';

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
        'dist/js/kalibao.backend.cms.cmsPage.js',
        'dist/js/kalibao.backend.cms.CmsPageList.js',
        'dist/js/kalibao.backend.cms.CmsPageEdit.js',
        'dist/js/kalibao.backend.cms.CmsPageTranslate.js',
    ];

    /**
     * @inheritdoc
     */
    public $css = [
        'dist/css/kalibao.backend.cms.cms-page.css',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'kalibao\backend\components\web\AppAsset'
    ];
}