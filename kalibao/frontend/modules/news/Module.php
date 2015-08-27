<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\frontend\modules\news;

use Yii;
use kalibao\common\components\cms\CmsPageService;

/**
 * Class Module
 *
 * @package kalibao\frontend\modules\news
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class Module extends \yii\base\Module implements \yii\base\BootstrapInterface
{
    public function bootstrap($app)
    {
        foreach (Yii::$app->appLanguage->getAppLanguages() as $language) {
            // slug
            $slug = CmsPageService::getSlugById(46, $language);
            // add rules
            $app->getUrlManager()->addRules([
                [
                    'pattern' => '<language:'.$language.'>/<cms_slug:'.$slug.'>/<page:\d+>',
                    'route' => 'news/news/index',
                    'defaults' => ['page' => 1]
                ],
            ], false);
        }
    }
}