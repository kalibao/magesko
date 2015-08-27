<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license http://www.kalibao.com/license/
 */

namespace kalibao\backend\modules\cms\components\cmsSimpleMenu\web;

use kalibao\common\components\web\AssetBundle;

/**
 * Class CmsSimpleMenuAsset
 *
 * @package kalibao\backend\modules\cms\components\cmsSimpleMenu\web
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class CmsSimpleMenuAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@kalibao/backend/modules/cms/components/cmsSimpleMenu/resources';

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
        'dist/js/kalibao.backend.cms.CmsSimpleMenuList.js',
        'dist/js/kalibao.backend.cms.CmsSimpleMenuEdit.js',
        'dist/js/kalibao.backend.cms.CmsSimpleMenuTranslate.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'kalibao\backend\components\web\AppAsset'
    ];
}