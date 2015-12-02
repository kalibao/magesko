<?php
/**
 * @copyright Copyright (c) 2015 Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\frontend\modules\products;

use Yii;
use kalibao\common\components\cms\CmsPageService;

/**
 * Class Module
 *
 * @package kalibao\frontend\modules\products
 * @version 1.0
 */
class Module extends \yii\base\Module implements \yii\base\BootstrapInterface
{
    public function bootstrap($app)
    {
        foreach (Yii::$app->appLanguage->getAppLanguages() as $language) {
            // slug
            $list    = CmsPageService::getSlugById(47, $language);
            $details = CmsPageService::getSlugById(48, $language);
            // add rules
            $app->getUrlManager()->addRules([
                [
                    'pattern' => '<language:'.$language.'>/<cms_slug:'.$list.'>/<page:\d+>',
                    'route' => 'products/products/index',
                    'defaults' => ['page' => 1]
                ],
            ], false);
            $app->getUrlManager()->addRules([
                [
                    'pattern' => '<language:'.$language.'>/<cms_slug:'.$list.'>/<category:[\w-]+>/<page:\d+>',
                    'route' => 'products/products/category',
                    'defaults' => ['page' => 1]
                ],
            ], false);
            $app->getUrlManager()->addRules([
                [
                    'pattern' => '<language:'.$language.'>/<cms_slug:'.$details.'>/<name:[\w-]+>',
                    'route' => 'products/products/details',
                    'defaults' => ['page' => 1]
                ],
            ], false);
        }
    }
}