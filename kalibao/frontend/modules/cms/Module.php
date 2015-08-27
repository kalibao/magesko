<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\frontend\modules\cms;

use Yii;

/**
 * Class Module
 *
 * @package kalibao\frontend\modules\cms
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class Module extends \yii\base\Module implements \yii\base\BootstrapInterface
{
    public function bootstrap($app)
    {
        // languages
        $joinLanguages = implode('|', Yii::$app->appLanguage->getAppLanguages());
        // add rules
        $app->getUrlManager()->addRules(
            [
                [
                    'pattern' => '<language:'.$joinLanguages.'>/<cms_slug[\w\-]+>',
                    'route' => 'cms/cms/index',
                    'defaults' => ['cms_slug' => 'home']
                ],
            ],
            false
        );
    }
}