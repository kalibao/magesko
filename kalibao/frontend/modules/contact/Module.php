<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\frontend\modules\contact;

use kalibao\common\components\cms\CmsPageService;
use Yii;

/**
 * Class Module
 *
 * @package kalibao\frontend\modules\contact
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class Module extends \yii\base\Module implements \yii\base\BootstrapInterface
{
    public function bootstrap($app)
    {
        foreach (Yii::$app->appLanguage->getAppLanguages() as $language) {
            // slug
            $slug = CmsPageService::getSlugById(45, $language);
            // add rules
            $app->getUrlManager()->addRules([
                '<language:'.$language.'>/<cms_slug:'.$slug.'>' => 'contact/contact/index',
                '<language:'.$language.'>/<cms_slug:'.$slug.'>/<action[\w\-]+>' => 'contact/contact/<action>',
            ], false);
        }
    }
}